<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'level_name',
        'day',
        'is_completed',
        'score',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
