<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $fillable = [
        'analysis_id', 'product_id', 'usage_id', 
        'match_score', 'rank', 'was_shown', 'user_clicked'
    ];

    public function analysis()
    {
        return $this->belongsTo(SkinAnalysis::class, 'analysis_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function usage()
    {
        return $this->belongsTo(ProductUsage::class, 'usage_id');
    }
}
