<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'question', 'options', 'answer'];

    protected $casts = [
        'options' => 'array',
    ];

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }

    public function testQuestions()
    {
        return $this->hasMany(TestQuestion::class);
    }
}
