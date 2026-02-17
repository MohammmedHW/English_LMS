<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Level;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Course::all()
        ]);
    }

    public function levels($course_id)
    {
        $levels = Level::where('course_id', $course_id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $levels
        ]);
    }
}
