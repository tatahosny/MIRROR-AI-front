<?php

namespace App\Services;

use App\Ai\Agents\SkinAnalysisAgent;
use App\Models\SkinAnalysis;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Ai\Files;
use App\Services\RecommendationService;

class SkinAnalysisService
{
    public function __construct(
        protected RecommendationService $recommendationService
    ) {}

    /**
     * Analyze a facial image and persist the result.
     *
     * @param string|null $userAnswers Context like pregnancy, chronic diseases
     * @return array<string, mixed>
     * @throws \RuntimeException when the image fails validation (invalid/blurry/no-face)
     */
    public function analyze(UploadedFile $image, ?User $user, Request $request, ?string $userAnswers = null): array
    {
        // 1. Store the image on public disk
        $path = $image->store('skin-analyses', 'public');

        try {
            // 2. Call the AI agent with image attachment and user context
            $response = (new SkinAnalysisAgent(userAnswers: $userAnswers))->prompt(
                'Analyze this facial image and provide a clinical skin assessment.',
                attachments: [
                    Files\Image::fromPath(Storage::disk('public')->path($path)),
                ]
            );

            // 3. Check status — agent may return error for invalid/low-quality images
            $status = $response['status'] ?? 'error';

            if ($status === 'error') {
                return [
                    'id'      => null,
                    'status'  => 'error',
                    'reason'  => $response['reason'] ?? 'invalid_image_no_clear_face_or_poor_quality',
                    'message' => 'Image validation failed. Please upload a clear, front-facing, well-lit photo.',
                ];
            }

            // 4. Extract structured data from agent response
            $skinType        = $response['skin_type']        ?? null;
            $sensitiveBarrier = $response['sensitive_barrier'] ?? false;
            $sensitivityNote  = $response['sensitivity_note'] ?? null;
            $detailedConcerns = $response['detailed_concerns'] ?? null;
            $globalScores    = $response['global_scores']    ?? null;
            $arabicSummary   = $response['summary']        ?? null;

            // 5. Build full analysis array for storage & response
            $fullAnalysis = [
                'skin_type'        => $skinType,
                'sensitive_barrier' => $sensitiveBarrier,
                'sensitivity_note'  => $sensitivityNote,
                'detailed_concerns' => $detailedConcerns,
                'global_scores'    => $globalScores,
                'summary'          => $arabicSummary,
            ];

            // 6. Persist to skin_analyses table
            $analysis = SkinAnalysis::create([
                'user_id'          => $user?->id,
                'image_path'       => $path,
                'detected_skin_type' => $skinType,
                'sensitive_barrier' => $sensitiveBarrier,
                'detected_concerns' => array_merge($detailedConcerns ?? [], [
                    'sensitivity_note' => $sensitivityNote
                ]),
                'summary'          => $arabicSummary,
                'global_scores'    => $globalScores,
                'user_answers'     => $userAnswers,
                'ip_address'       => $request->ip(),
            ]);

            return [
                'id'       => $analysis->id,
                'status'   => 'success',
                'analysis' => $fullAnalysis,
            ];
        } catch (\Throwable $e) {
            throw $e;
        }
    }


}
