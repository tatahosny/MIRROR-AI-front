<?php

namespace App\Http\Controllers;

use App\Services\AnalysisService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

/**
 * DashboardController
 *
 * Handles dashboard views and analytics data
 */
class DashboardController extends Controller
{
    public function __construct(protected AnalysisService $analysisService)
    {
    }

    /**
     * Show main dashboard
     */
    public function index(): View
    {
        return view('dashboard.index');
    }

    /**
     * Show analysis history
     */
    public function history(): View
    {
        return view('dashboard.history');
    }

    /**
     * Show comparison dashboard (multi-session analysis)
     */
    public function comparison(): View
    {
        return view('dashboard.comparison');
    }

    /**
     * Get dashboard analytics data
     */
    public function getAnalytics(): JsonResponse
    {
        return response()->json();
    }

    /**
     * Get history data
     */
    public function getHistory(): JsonResponse
    {
        return response()->json();
    }

    /**
     * Get comparison data
     */
    public function getComparison(): JsonResponse
    {
        return response()->json();
    }
}
