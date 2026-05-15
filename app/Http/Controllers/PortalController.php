<?php

namespace App\Http\Controllers;

use App\Models\SkinAnalysis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PortalController extends Controller
{
    /** Show login page */
    public function showLogin(Request $request)
    {
        $analysisUuid = $request->query('analysis_uuid');

        if (Auth::check()) {
            return redirect()->route('portal.dashboard', ['analysis_uuid' => $analysisUuid]);
        }

        return view('auth.login', compact('analysisUuid'));
    }

    /** Show register page */
    public function showRegister(Request $request)
    {
        $analysisUuid = $request->query('analysis_uuid');

        if (Auth::check()) {
            return redirect()->route('portal.dashboard', ['analysis_uuid' => $analysisUuid]);
        }

        return view('auth.register', compact('analysisUuid'));
    }

    /** Handle login via form POST */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $analysisUuid = $request->input('analysis_uuid');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if ($analysisUuid) {
                $this->linkAnalysis($analysisUuid, Auth::user());
            }

            return redirect()->route('portal.dashboard')->with('success', 'Welcome back!');
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    /** Handle register via form POST */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $analysisUuid = $request->input('analysis_uuid');

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        if ($analysisUuid) {
            $this->linkAnalysis($analysisUuid, $user);
        }

        return redirect()->route('portal.dashboard')->with('success', 'Account created successfully!');
    }

    /** Show user dashboard */
    public function dashboard(Request $request)
    {
        $user     = Auth::user();
        $analyses = SkinAnalysis::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $comparison  = $this->generateComparison($analyses);
        $latestAnalysis = $analyses->first();

        // Link pending analysis if passed via URL
        if ($request->query('analysis_uuid')) {
            $this->linkAnalysis($request->query('analysis_uuid'), $user);
            return redirect()->route('portal.dashboard');
        }

        return view('portal.dashboard', compact('user', 'analyses', 'comparison', 'latestAnalysis'));
    }

    public function reports(Request $request)
    {
        $user = Auth::user();
        $analyses = SkinAnalysis::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('portal.reports', compact('user', 'analyses'));
    }

    public function progress(Request $request)
    {
        $user = Auth::user();
        $analyses = SkinAnalysis::where('user_id', $user->id)
            ->orderBy('created_at', 'asc') // chronological for progress
            ->get();
        return view('portal.progress', compact('user', 'analyses'));
    }

    public function locations(Request $request)
    {
        $user = Auth::user();
        return view('portal.locations', compact('user'));
    }

    /** Logout */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /** Link anonymous analysis to a user */
    protected function linkAnalysis($uuid, User $user)
    {
        SkinAnalysis::where('uuid', $uuid)
            ->whereNull('user_id')
            ->update(['user_id' => $user->id]);
    }

    /** Generate comparison between latest 2 analyses */
    protected function generateComparison($analyses)
    {
        if ($analyses->count() < 2) return null;

        $latest   = $analyses[0];
        $previous = $analyses[1];

        $latestScores = $latest->global_scores  ?? [];
        $prevScores   = $previous->global_scores ?? [];

        $diff = [];
        foreach ($latestScores as $key => $score) {
            if (isset($prevScores[$key])) {
                $diff[$key] = round($score - $prevScores[$key], 1);
            }
        }

        $improved    = array_filter($diff, fn($v) => $v > 0);
        $deteriorated = array_filter($diff, fn($v) => $v < 0);

        $needsDoctor = false;
        foreach ($deteriorated as $change) {
            if (abs($change) >= 15) { $needsDoctor = true; break; }
        }

        return [
            'difference'       => $diff,
            'improved'         => $improved,
            'deteriorated'     => $deteriorated,
            'needs_doctor'     => $needsDoctor,
            'latest_summary'   => $latest->summary,
            'previous_summary' => $previous->summary,
            'latest_date'      => $latest->created_at,
            'previous_date'    => $previous->created_at,
        ];
    }
}
