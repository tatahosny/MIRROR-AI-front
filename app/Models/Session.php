<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'session_id', 'user_id', 'ip_address', 'user_agent', 
        'login_time', 'last_activity', 'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
