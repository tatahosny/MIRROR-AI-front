<?php

namespace App\Http\Controllers;

use App\Models\SkinSession;
use App\Services\AnalysisService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * QRController
 *
 * Handles QR code generation, scanning, and guest session migration
 * Implements the QR login flow with optional skip capability
 */
class QRController extends Controller
{
    public function __construct(protected AnalysisService $analysisService)
    {
    }

    /**
     * Generate QR code for session token
     */
    public function generate(Request $request): JsonResponse
    {
        return response()->json();
    }

    /**
     * Handle QR code scan - redirect to login with session token
     */
    public function scan(string $token): RedirectResponse
    {
        return redirect()->route('login');
    }

    /**
     * Skip QR flow - user continues as guest
     */
    public function skip(string $token): JsonResponse
    {
        return response()->json();
    }

    /**
     * QR modal page
     */
    public function modal(string $sessionToken): View
    {
        return view('qr.modal', [
            'sessionToken' => $sessionToken,
        ]);
    }

    /**
     * Migrate guest session after login
     */
    public function migrateSession(Request $request): JsonResponse
    {
        return response()->json();
    }

    /**
     * Get QR status
     */
    public function getStatus(string $token): JsonResponse
    {
        return response()->json();
    }
}
