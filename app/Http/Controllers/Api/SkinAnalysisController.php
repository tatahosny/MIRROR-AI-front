<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SkinAnalysisResource;
use App\Models\SkinAnalysis;
use App\Services\SkinAnalysisService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkinAnalysisController extends Controller
{
    public function __construct(private SkinAnalysisService $service) {}

    public function analyze(Request $request): JsonResponse
    {
        $request->validate([
            'image'        => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:10240'],
            'user_answers' => ['nullable', 'string'],
        ]);

        try {
            $result = $this->service->analyze(
                $request->file('image'),
                Auth::user(),
                $request,
                $request->input('user_answers')
            );

            if ($result['status'] === 'error') {
                return response()->json([
                    'success' => false,
                    'status'  => 'error',
                    'message' => $result['message'],
                    'reason'  => $result['reason'],
                ], 422);
            }

            $analysis = SkinAnalysis::with(['recommendations.product', 'recommendations.usage'])->find($result['id']);

            return (new SkinAnalysisResource($analysis))
                ->response()
                ->setStatusCode(201);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Analysis failed: ' . $e->getMessage(),
            ], 500);
        }
    }



    /**
     * Show a specific skin analysis.
     */
    public function show(string $uuid, Request $request): SkinAnalysisResource
    {
        $analysis = SkinAnalysis::with(['recommendations.product', 'recommendations.usage'])
            ->where('uuid', $uuid)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return new SkinAnalysisResource($analysis);
    }
}
