<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'lesson_id', 
        'score', 
        'is_passed', 
        'exercises_completed', 
        'test_locked'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
