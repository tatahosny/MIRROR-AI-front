<?php

namespace App\Services\AI;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * GeminiService
 *
 * Handles integration with Google Gemini API for skin analysis
 * Sends image and receives structured analysis response
 */
class GeminiService
{
    protected string $apiKey;
    protected string $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
    }

    /**
     * Analyze skin image using Gemini API
     *
     * @param string $imagePath Path to the image file
     * @return array Structured analysis response
     * @throws Exception
     */
    public function analyzeSkinImage(string $imagePath): array
    {
        try {
            $imageBase64 = $this->encodeImageToBase64($imagePath);

            $payload = $this->buildAnalysisPayload($imageBase64);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . "?key={$this->apiKey}", $payload);

            if (!$response->successful()) {
                throw new Exception("Gemini API Error: {$response->status()} - {$response->body()}");
            }

            return $this->parseGeminiResponse($response->json());

        } catch (Exception $e) {
            Log::error('Gemini API Error', [
                'error' => $e->getMessage(),
                'image_path' => $imagePath,
            ]);
            throw $e;
        }
    }

    /**
     * Encode image to base64
     *
     * @param string $imagePath
     * @return string
     * @throws Exception
     */
    protected function encodeImageToBase64(string $imagePath): string
    {
        if (!file_exists($imagePath)) {
            throw new Exception("Image file not found: {$imagePath}");
        }

        return base64_encode(file_get_contents($imagePath));
    }

    /**
     * Build Gemini API payload
     *
     * @param string $imageBase64
     * @return array
     */
    protected function buildAnalysisPayload(string $imageBase64): array
    {
        $systemPrompt = <<<'PROMPT'
You are a professional dermatologist AI assistant specializing in skin analysis.
Analyze the provided skin image and return a structured JSON response with the following exact format:
{
    "skin_type": "oily|dry|combination|normal|sensitive",
    "acne_score": <0-100>,
    "hydration_score": <0-100>,
    "pigmentation_score": <0-100>,
    "sensitivity_score": <0-100>,
    "overall_score": <0-100>,
    "recommendations": [
        "recommendation 1",
        "recommendation 2",
        "recommendation 3"
    ],
    "analysis_notes": "Brief professional analysis"
}

Guidelines:
- Acne Score: 0 (no acne) to 100 (severe acne)
- Hydration Score: 0 (very dry) to 100 (well-hydrated)
- Pigmentation Score: 0 (even tone) to 100 (significant issues)
- Sensitivity Score: 0 (not sensitive) to 100 (highly sensitive)
- Overall Score: Average of all metrics
- Provide at least 3 actionable recommendations
- Be professional and encouraging in your analysis
PROMPT;

        return [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        [
                            'text' => $systemPrompt,
                        ],
                        [
                            'inlineData' => [
                                'mimeType' => 'image/jpeg',
                                'data' => $imageBase64,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Parse Gemini API response
     *
     * @param array $response
     * @return array
     * @throws Exception
     */
    protected function parseGeminiResponse(array $response): array
    {
        try {
            $content = $response['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$content) {
                throw new Exception('Invalid response structure from Gemini API');
            }

            // Extract JSON from response (in case there's extra text)
            $jsonMatch = preg_match('/\{.*\}/s', $content, $matches);
            if (!$jsonMatch) {
                throw new Exception('No JSON found in Gemini response');
            }

            $analysisData = json_decode($matches[0], true);

            if (!$analysisData) {
                throw new Exception('Invalid JSON in Gemini response');
            }

            return $this->normalizeAnalysisData($analysisData);

        } catch (Exception $e) {
            Log::error('Gemini Response Parse Error', [
                'error' => $e->getMessage(),
                'response' => $response,
            ]);
            throw $e;
        }
    }

    /**
     * Normalize and validate analysis data
     *
     * @param array $data
     * @return array
     */
    protected function normalizeAnalysisData(array $data): array
    {
        return [
            'skin_type' => $data['skin_type'] ?? 'normal',
            'acne_score' => min(100, max(0, (int)($data['acne_score'] ?? 0))),
            'hydration_score' => min(100, max(0, (int)($data['hydration_score'] ?? 0))),
            'pigmentation_score' => min(100, max(0, (int)($data['pigmentation_score'] ?? 0))),
            'sensitivity_score' => min(100, max(0, (int)($data['sensitivity_score'] ?? 0))),
            'overall_score' => min(100, max(0, (int)($data['overall_score'] ?? 0))),
            'recommendations' => $data['recommendations'] ?? [],
            'analysis_notes' => $data['analysis_notes'] ?? '',
            'raw_response' => $data,
        ];
    }

    /**
     * Generate comparison summary using Gemini
     *
     * @param array $result1
     * @param array $result2
     * @return string
     */
    public function generateComparisonSummary(array $result1, array $result2): string
    {
        try {
            $prompt = <<<'PROMPT'
Compare these two skin analysis results and provide a brief, encouraging summary of improvements.
Focus on positive changes and actionable advice.

First Analysis:
- Acne: %s, Hydration: %s, Pigmentation: %s, Sensitivity: %s

Second Analysis (Recent):
- Acne: %s, Hydration: %s, Pigmentation: %s, Sensitivity: %s

Provide a 2-3 sentence professional comparison highlighting improvements and recommendations.
PROMPT;

            $payload = [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            [
                                'text' => sprintf(
                                    $prompt,
                                    $result1['acne_score'],
                                    $result1['hydration_score'],
                                    $result1['pigmentation_score'],
                                    $result1['sensitivity_score'],
                                    $result2['acne_score'],
                                    $result2['hydration_score'],
                                    $result2['pigmentation_score'],
                                    $result2['sensitivity_score']
                                ),
                            ],
                        ],
                    ],
                ],
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . "?key={$this->apiKey}", $payload);

            if ($response->successful()) {
                return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '';
            }

            return '';

        } catch (Exception $e) {
            Log::error('Gemini Comparison Summary Error', ['error' => $e->getMessage()]);
            return '';
        }
    }
}
