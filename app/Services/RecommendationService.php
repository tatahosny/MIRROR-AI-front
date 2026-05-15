<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Recommendation;
use App\Models\SkinAnalysis;
use Illuminate\Support\Collection;

class RecommendationService
{
    /**
     * Generate recommendations for a given skin analysis.
     */
    public function generate(SkinAnalysis $analysis): Collection
    {
        $skinType = $analysis->detected_skin_type;
        $concerns = $analysis->detected_concerns;

        // Get all active products
        $candidates = Product::query()
            ->where('is_active', true)
            ->with('usage')
            ->get();

        $scoredProducts = $candidates->map(function (Product $product) use ($skinType, $concerns) {
            $usage = $product->usage;
            if (!$usage) return null;

            // Hard Filtering
            $suitableTypes = array_map('trim', explode(',', $usage->suitable_for_skin_types ?? ''));
            $isCompatible = in_array($skinType, $suitableTypes) || in_array('All types', $suitableTypes);
            
            if (!$isCompatible) return null;

            // Scoring
            $score = 0.0;
            $matchCount = 0;
            $productConcerns = array_map('trim', explode(',', $usage->suitable_for_concerns ?? ''));
            
            foreach ($concerns as $key => $data) {
                if (isset($data['detected']) && $data['detected'] === true) {
                    if (in_array($key, $productConcerns)) {
                        $severity = $data['severity'] ?? 0.5;
                        $score += 1.0 * (1.0 + $severity);
                        $matchCount++;
                    }
                }
            }

            $priorityFactor = (6 - ($usage->priority ?? 5)) / 5;
            $finalScore = ($matchCount > 0 ? ($score / ($matchCount * 2)) : 0.2) * $priorityFactor;

            return (object) [
                'product' => $product,
                'usage'   => $usage,
                'score'   => round($finalScore, 2),
            ];
        })->filter()->sortByDesc('score');

        // Select a balanced routine
        $recommendations = new Collection();

        foreach ($scoredProducts as $sc) {
            $product = $sc->product;
            $categoryId = $product->category_id;

            $categoryLimit = ($categoryId == 3) ? 2 : 1;
            
            $currentCount = $recommendations->filter(fn($item) => $item->product->category_id == $categoryId)->count();

            if ($currentCount < $categoryLimit) {
                $recommendations->push($sc);
            }

            if ($recommendations->count() >= 5) break;
        }

        // Persist to recommendations table
        $rank = 1;
        $saved = collect();
        foreach ($recommendations as $sc) {
            $saved->push(Recommendation::create([
                'analysis_id' => $analysis->id,
                'product_id'  => $sc->product->id,
                'usage_id'    => $sc->usage->id,
                'match_score' => $sc->score ?? 0,
                'rank'        => $rank++,
            ]));
        }

        return $saved;
    }
}
