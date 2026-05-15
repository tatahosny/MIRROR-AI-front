<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductUsage extends Model
{
    protected $table = 'product_usage';

    protected $fillable = [
        'product_id', 'suitable_for_skin_types', 'suitable_for_concerns',
        'usage_frequency', 'usage_time', 'how_to_use', 'amount_to_use',
        'warnings', 'priority', 'is_essential'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
