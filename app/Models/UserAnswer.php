<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'lesson_id', 'test_question_id', 'answer', 'is_correct'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function testQuestion()
    {
        return $this->belongsTo(TestQuestion::class);
    }
}
