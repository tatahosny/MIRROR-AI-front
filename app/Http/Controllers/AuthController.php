<?php

namespace App\Http\Controllers;

use App\Models\SkinSession;
use App\Services\AnalysisService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * AuthController
 *
 * Handles authentication flows
 * Manages QR-based login and session migration
 */
class AuthController extends Controller
{
    public function __construct(protected AnalysisService $analysisService)
    {
    }

    /**
     * Show login form
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login with optional session token
     */
    public function login(Request $request): JsonResponse
    {
        return response()->json();
    }

    /**
     * Show registration form
     */
    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    /**
     * Handle registration with optional session token
     */
    public function register(Request $request): JsonResponse
    {
        return response()->json();
    }

    /**
     * Handle logout
     */
    public function logout(): RedirectResponse
    {
        return redirect('/');
    }

    /**
     * Migrate guest session to authenticated user
     * Called after successful login/register with session token
     */
    public function migrateGuestSession(Request $request): JsonResponse
    {
        return response()->json();
    }
}
