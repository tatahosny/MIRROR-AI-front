<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecommendationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'match_score' => (float) $this->match_score,
            'rank'        => (int) $this->rank,
            
            // Product info
            'product' => [
                'id'          => $this->product->id,
                'name'        => $this->product->name,
                'description' => $this->product->description,
                'price'       => (float) $this->product->price,
                'image_url'   => $this->product->image_url,
            ],
            
            // Usage info
            'usage' => [
                'usage_frequency' => $this->usage->usage_frequency,
                'usage_time'      => $this->usage->usage_time,
                'how_to_use'      => $this->usage->how_to_use,
                'amount_to_use'   => $this->usage->amount_to_use,
                'warnings'        => $this->usage->warnings,
            ],
        ];
    }
}
