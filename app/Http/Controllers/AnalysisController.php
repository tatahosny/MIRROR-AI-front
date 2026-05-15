<?php

namespace App\Http\Controllers;

use App\Models\SkinSession;
use App\Services\AnalysisService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * AnalysisController
 *
 * Handles skin analysis upload, processing, and result display
 */
class AnalysisController extends Controller
{
    public function __construct(protected AnalysisService $analysisService)
    {
    }

    /**
     * Show upload page
     */
    public function uploadForm(): View
    {
        return view('analysis.upload');
    }

    /**
     * Process image upload and trigger analysis
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json();
    }

    /**
     * Show analysis result page
     */
    public function showResult(SkinSession $session): View
    {
        return view('analysis.result', [
            'session' => $session,
        ]);
    }

    /**
     * Get analysis history for authenticated user
     */
    public function history(): View
    {
        return view('analysis.history');
    }

    /**
     * Get comparison data
     */
    public function comparison(int $userId): View
    {
        return view('analysis.comparison', [
            'userId' => $userId,
        ]);
    }

    /**
     * API endpoint to fetch result data
     */
    public function getResult(SkinSession $session): JsonResponse
    {
        return response()->json();
    }

    /**
     * API endpoint to fetch analysis history
     */
    public function getHistory(): JsonResponse
    {
        return response()->json();
    }
}
