<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Get all levels (Junior, School, College)
     */
    public function levels()
    {
        $levels = Level::all();
        return response()->json([
            'status' => 'success',
            'data' => $levels
        ]);
    }

    /**
     * Get courses for a specific level
     */
    public function index($level_id)
    {
        $courses = Course::where('level_id', $level_id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $courses
        ]);
    }
}
