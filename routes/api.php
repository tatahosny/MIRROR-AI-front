<?php

use App\Http\Controllers\Api\SkinAnalysisController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Skin Analysis Routes
|--------------------------------------------------------------------------
*/

Route::post('/skin-analysis', [SkinAnalysisController::class, 'analyze']);

Route::post('/portal/login', [App\Http\Controllers\PortalController::class, 'login']);
Route::post('/portal/register', [App\Http\Controllers\PortalController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/skin-analysis/{uuid}', [SkinAnalysisController::class, 'show']);
    Route::get('/portal/dashboard', [App\Http\Controllers\PortalController::class, 'dashboard']);
});

