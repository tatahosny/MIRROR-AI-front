<?php

namespace App\Services;

use App\Models\AnalysisComparison;
use App\Models\AnalysisLog;
use App\Models\SkinResult;
use App\Models\SkinSession;
use App\Models\User;
use App\Services\AI\GeminiService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * AnalysisService
 *
 * Orchestrates the complete skin analysis workflow:
 * - Session creation and management
 * - Image processing and storage
 * - Gemini API integration
 * - Result persistence
 * - Comparison logic
 * - Session migration to user accounts
 */
class AnalysisService
{
    protected GeminiService $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    /**
     * Create a new guest session
     *
     * @param string|null $deviceId
     * @param string|null $ipAddress
     * @return SkinSession
     */
    public function createGuestSession(?string $deviceId = null, ?string $ipAddress = null): SkinSession
    {
        $sessionToken = Str::random(64);

        $session = SkinSession::create([
            'session_token' => $sessionToken,
            'is_guest' => true,
            'device_id' => $deviceId,
            'ip_address' => $ipAddress,
        ]);

        AnalysisLog::logStep($session->id, 'session_created', 'completed', [
            'session_token' => $sessionToken,
            'type' => 'guest',
        ]);

        return $session;
    }

    /**
     * Process skin analysis for a session
     *
     * @param SkinSession $session
     * @param string $imagePath Local path to uploaded image
     * @return SkinResult
     * @throws Exception
     */
    public function processAnalysis(SkinSession $session, string $imagePath): SkinResult
    {
        DB::beginTransaction();

        try {
            // Step 1: Create result record with pending status
            AnalysisLog::logStep($session->id, 'upload', 'completed');

            $result = SkinResult::create([
                'session_id' => $session->id,
                'image_path' => $imagePath,
                'analysis_status' => 'pending',
            ]);

            // Step 2: Store image in cloud storage
            AnalysisLog::logStep($session->id, 'storage', 'in_progress');

            $storedPath = $this->storeImage($imagePath, $session->id);
            $imageUrl = Storage::disk('public')->url($storedPath);

            $result->update([
                'image_url' => $imageUrl,
            ]);

            // Step 3: Run Gemini analysis
            AnalysisLog::logStep($session->id, 'gemini_processing', 'in_progress');

            $result->markAsProcessing();

            $analysisData = $this->geminiService->analyzeSkinImage($imagePath);

            // Step 4: Store analysis results
            $result->update([
                'skin_type' => $analysisData['skin_type'],
                'acne_score' => $analysisData['acne_score'],
                'hydration_score' => $analysisData['hydration_score'],
                'pigmentation_score' => $analysisData['pigmentation_score'],
                'sensitivity_score' => $analysisData['sensitivity_score'],
                'overall_score' => $analysisData['overall_score'],
                'recommendations' => $analysisData['recommendations'],
                'analysis_data' => $analysisData['raw_response'],
                'analysis_status' => 'completed',
            ]);

            AnalysisLog::logStep($session->id, 'completion', 'completed', [
                'skin_type' => $analysisData['skin_type'],
                'overall_score' => $analysisData['overall_score'],
            ]);

            DB::commit();

            // Trigger comparison if user has multiple results
            if ($session->user_id && $session->user()->exists()) {
                $this->generateComparison($session->user_id, $session->id);
            }

            return $result;

        } catch (Exception $e) {
            DB::rollBack();

            AnalysisLog::logStep($session->id, 'completion', 'failed', null, $e->getMessage());

            if (isset($result)) {
                $result->markAsFailed($e->getMessage());
            }

            Log::error('Analysis Processing Failed', [
                'session_id' => $session->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Store image in storage
     *
     * @param string $imagePath
     * @param int $sessionId
     * @return string
     */
    protected function storeImage(string $imagePath, int $sessionId): string
    {
        $filename = "session_{$sessionId}_" . Str::random(16) . '.jpg';
        $storagePath = "skin-analysis/{$sessionId}/{$filename}";

        Storage::disk('public')->put(
            $storagePath,
            file_get_contents($imagePath)
        );

        return $storagePath;
    }

    /**
     * Migrate guest session to user account
     *
     * @param SkinSession $session
     * @param User $user
     * @return void
     */
    public function migrateSessionToUser(SkinSession $session, User $user): void
    {
        $session->migrateToUser($user);

        Log::info('Session migrated to user', [
            'session_id' => $session->id,
            'user_id' => $user->id,
        ]);
    }

    /**
     * Generate comparison between latest and previous analysis
     *
     * @param int $userId
     * @param int $currentSessionId
     * @return AnalysisComparison|null
     */
    public function generateComparison(int $userId, int $currentSessionId): ?AnalysisComparison
    {
        $user = User::find($userId);
        if (!$user) {
            return null;
        }

        // Get latest two results for this user
        $results = SkinResult::whereHas('session', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->where('analysis_status', 'completed')
        ->latest('created_at')
        ->limit(2)
        ->get();

        if ($results->count() < 2) {
            return null;
        }

        $latestResult = $results->first();
        $previousResult = $results->last();

        // Calculate improvements
        $acneImprovement = $previousResult->acne_score - $latestResult->acne_score;
        $hydrationImprovement = $latestResult->hydration_score - $previousResult->hydration_score;
        $pigmentationImprovement = $previousResult->pigmentation_score - $latestResult->pigmentation_score;
        $sensitivityImprovement = $previousResult->sensitivity_score - $latestResult->sensitivity_score;

        $overallImprovement = (
            $acneImprovement +
            $hydrationImprovement +
            $pigmentationImprovement +
            $sensitivityImprovement
        ) / 4;

        // Determine trend
        $trendDirection = $overallImprovement > 0 ? 'up' : ($overallImprovement < 0 ? 'down' : 'stable');

        // Generate AI summary
        $aiSummary = $this->geminiService->generateComparisonSummary(
            $previousResult->getScores(),
            $latestResult->getScores()
        );

        // Create comparison record
        $comparison = AnalysisComparison::create([
            'user_id' => $userId,
            'session_id_1' => $previousResult->session_id,
            'session_id_2' => $latestResult->session_id,
            'acne_improvement' => (int)$acneImprovement,
            'hydration_improvement' => (int)$hydrationImprovement,
            'pigmentation_improvement' => (int)$pigmentationImprovement,
            'sensitivity_improvement' => (int)$sensitivityImprovement,
            'overall_improvement' => (int)$overallImprovement,
            'trend_direction' => $trendDirection,
            'comparison_summary' => [
                'previous_scores' => $previousResult->getScores(),
                'latest_scores' => $latestResult->getScores(),
            ],
            'ai_generated_summary' => $aiSummary,
        ]);

        Log::info('Comparison generated', [
            'user_id' => $userId,
            'comparison_id' => $comparison->id,
            'overall_improvement' => $overallImprovement,
        ]);

        return $comparison;
    }

    /**
     * Get user analysis history with comparison data
     *
     * @param int $userId
     * @return array
     */
    public function getUserAnalysisHistory(int $userId): array
    {
        $user = User::find($userId);

        if (!$user) {
            return [];
        }

        $results = SkinResult::whereHas('session', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->where('analysis_status', 'completed')
        ->latest('created_at')
        ->get();

        $comparisons = AnalysisComparison::where('user_id', $userId)
            ->latest('created_at')
            ->get();

        return [
            'total_analyses' => $results->count(),
            'results' => $results,
            'comparisons' => $comparisons,
            'can_compare' => $results->count() >= 2,
            'latest_improvement' => $comparisons->first()?->overall_improvement ?? null,
        ];
    }

    /**
     * Get session by token (for QR scanning)
     *
     * @param string $sessionToken
     * @return SkinSession|null
     */
    public function getSessionByToken(string $sessionToken): ?SkinSession
    {
        return SkinSession::where('session_token', $sessionToken)->first();
    }

    /**
     * Check if session has analysis results
     *
     * @param SkinSession $session
     * @return bool
     */
    public function hasAnalysisResults(SkinSession $session): bool
    {
        return $session->skinResults()->where('analysis_status', 'completed')->exists();
    }
}
