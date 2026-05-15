<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SkinAnalysisResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $concerns = $this->detected_concerns; // auto-cast to array

        return [
            'id'         => $this->id,
            'uuid'       => $this->uuid,
            'image_url'  => $this->image_path
                ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->image_path)
                : null,
            'analyzed_at' => $this->created_at?->toISOString(),

            // Skin profile
            'skin_type'        => $this->detected_skin_type,
            'sensitive_barrier' => (bool) $this->sensitive_barrier,
            'sensitivity_note' => $concerns['sensitivity_note'] ?? null,

            // Detailed concerns (5 categories)
            'concerns' => $concerns, // Return the whole array which now includes everything


            // Global visual scores (0–100)
            'global_scores' => $this->whenNotNull($this->global_scores),

            // Summary
            'summary' => $this->summary,

            // Recommendations
            'recommendations' => RecommendationResource::collection($this->whenLoaded('recommendations')),

            // Meta
            'user_id'    => $this->when($request->user()?->id === $this->user_id, $this->user_id),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
