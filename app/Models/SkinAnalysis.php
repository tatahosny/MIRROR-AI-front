<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SkinAnalysis extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'detected_skin_type',
        'sensitive_barrier',
        'detected_concerns',
        'summary',
        'global_scores',
        'user_answers',
        'image_path',
        'ip_address',
    ];

    protected $casts = [
        'detected_concerns' => 'array',
        'global_scores'     => 'array',
        'sensitive_barrier' => 'boolean',
        'user_answers'      => 'string',
    ];

    /**
     * Auto-generate UUID on creation.
     */
    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Find by UUID or fail.
     */
    public static function findByUuidOrFail(string $uuid): self
    {
        return static::where('uuid', $uuid)->firstOrFail();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'analysis_id');
    }
}
