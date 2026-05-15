<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalysisComparison extends Model
{
    protected $table = 'analysis_comparisons';

    protected $fillable = [
        'user_id',
        'session_id_1',
        'session_id_2',
        'acne_improvement',
        'hydration_improvement',
        'pigmentation_improvement',
        'sensitivity_improvement',
        'overall_improvement',
        'trend_direction',
        'comparison_summary',
        'ai_generated_summary',
    ];

    protected $casts = [
        'acne_improvement' => 'integer',
        'hydration_improvement' => 'integer',
        'pigmentation_improvement' => 'integer',
        'sensitivity_improvement' => 'integer',
        'overall_improvement' => 'integer',
        'comparison_summary' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user associated with this comparison
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the first session
     */
    public function sessionOne(): BelongsTo
    {
        return $this->belongsTo(SkinSession::class, 'session_id_1');
    }

    /**
     * Get the second session
     */
    public function sessionTwo(): BelongsTo
    {
        return $this->belongsTo(SkinSession::class, 'session_id_2');
    }

    /**
     * Get improvement percentages as array
     */
    public function getImprovements(): array
    {
        return [
            'acne' => $this->acne_improvement,
            'hydration' => $this->hydration_improvement,
            'pigmentation' => $this->pigmentation_improvement,
            'sensitivity' => $this->sensitivity_improvement,
            'overall' => $this->overall_improvement,
        ];
    }

    /**
     * Check if improvement is positive across metrics
     */
    public function hasOverallImprovement(): bool
    {
        return $this->overall_improvement >= 0;
    }
}
