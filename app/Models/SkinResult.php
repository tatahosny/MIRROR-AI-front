<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkinResult extends Model
{
    protected $table = 'skin_results';

    protected $fillable = [
        'session_id',
        'image_path',
        'image_url',
        'skin_type',
        'acne_score',
        'hydration_score',
        'pigmentation_score',
        'sensitivity_score',
        'overall_score',
        'recommendations',
        'analysis_data',
        'analysis_status',
        'analysis_error',
    ];

    protected $casts = [
        'acne_score' => 'integer',
        'hydration_score' => 'integer',
        'pigmentation_score' => 'integer',
        'sensitivity_score' => 'integer',
        'overall_score' => 'integer',
        'recommendations' => 'array',
        'analysis_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the session associated with this result
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(SkinSession::class, 'session_id');
    }

    /**
     * Check if analysis is complete
     */
    public function isAnalysisComplete(): bool
    {
        return $this->analysis_status === 'completed';
    }

    /**
     * Get all scores as array
     */
    public function getScores(): array
    {
        return [
            'acne' => $this->acne_score,
            'hydration' => $this->hydration_score,
            'pigmentation' => $this->pigmentation_score,
            'sensitivity' => $this->sensitivity_score,
            'overall' => $this->overall_score,
        ];
    }

    /**
     * Mark as processing
     */
    public function markAsProcessing(): void
    {
        $this->update(['analysis_status' => 'processing']);
    }

    /**
     * Mark as completed
     */
    public function markAsCompleted(): void
    {
        $this->update(['analysis_status' => 'completed']);
    }

    /**
     * Mark as failed
     */
    public function markAsFailed(string $error): void
    {
        $this->update([
            'analysis_status' => 'failed',
            'analysis_error' => $error,
        ]);
    }
}
