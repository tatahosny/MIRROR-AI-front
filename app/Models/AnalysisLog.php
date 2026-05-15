<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalysisLog extends Model
{
    protected $table = 'analysis_logs';

    protected $fillable = [
        'session_id',
        'step',
        'status',
        'meta',
        'error_message',
    ];

    protected $casts = [
        'meta' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the session associated with this log
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(SkinSession::class, 'session_id');
    }

    /**
     * Log a new step
     */
    public static function logStep(int $sessionId, string $step, string $status, ?array $meta = null, ?string $error = null): self
    {
        return self::create([
            'session_id' => $sessionId,
            'step' => $step,
            'status' => $status,
            'meta' => $meta,
            'error_message' => $error,
        ]);
    }
}
