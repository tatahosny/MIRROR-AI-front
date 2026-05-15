<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortalController;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/scan', function () {
    return view('index');
})->name('scan');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/features', function () {
    return view('features');
})->name('features');

// Authentication - Blade views
Route::get('/login', [PortalController::class, 'showLogin'])->name('login');
Route::post('/login', [PortalController::class, 'login']);

Route::get('/register', [PortalController::class, 'showRegister'])->name('register');
Route::post('/register', [PortalController::class, 'register']);

Route::middleware('auth')->prefix('portal')->name('portal.')->group(function () {
    Route::get('/dashboard', [PortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/reports', [PortalController::class, 'reports'])->name('reports');
    Route::get('/progress', [PortalController::class, 'progress'])->name('progress');
    Route::get('/locations', [PortalController::class, 'locations'])->name('locations');
    Route::post('/logout', [PortalController::class, 'logout'])->name('logout');
});
