<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'title', 'order', 'pass_score'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }

    public function test()
    {
        return $this->hasOne(Test::class);
    }
    
    public function results()
    {
        return $this->hasMany(LessonResult::class);
    }
}
