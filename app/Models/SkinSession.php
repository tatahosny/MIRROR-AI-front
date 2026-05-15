<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkinSession extends Model
{
    protected $table = 'skin_sessions';

    protected $fillable = [
        'user_id',
        'session_token',
        'is_guest',
        'device_id',
        'ip_address',
        'migrated_at',
    ];

    protected $casts = [
        'is_guest' => 'boolean',
        'migrated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user associated with this session
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all skin results for this session
     */
    public function skinResults(): HasMany
    {
        return $this->hasMany(SkinResult::class, 'session_id');
    }

    /**
     * Get all analysis logs for this session
     */
    public function analysisLogs(): HasMany
    {
        return $this->hasMany(AnalysisLog::class, 'session_id');
    }

    /**
     * Get the latest skin result
     */
    public function latestResult()
    {
        return $this->skinResults()->latest()->first();
    }

    /**
     * Check if this session is complete
     */
    public function isComplete(): bool
    {
        return $this->skinResults()->where('analysis_status', 'completed')->exists();
    }

    /**
     * Migrate guest session to user account
     */
    public function migrateToUser(User $user): void
    {
        $this->update([
            'user_id' => $user->id,
            'is_guest' => false,
            'migrated_at' => now(),
        ]);

        AnalysisLog::create([
            'session_id' => $this->id,
            'step' => 'migration',
            'status' => 'completed',
            'meta' => ['user_id' => $user->id],
        ]);
    }
}
