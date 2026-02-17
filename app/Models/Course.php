<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'duration_days',
        'price',
        'description',
    ];

    public function levels()
    {
        return $this->hasMany(Level::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
