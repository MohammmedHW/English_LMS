<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_id',
        'day_number',
        'title',
        'description',
        'video_url',
        'notes',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
