<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index($level_id)
    {
        $lessons = Lesson::where('level_id', $level_id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $lessons
        ]);
    }

    public function show($id)
    {
        $lesson = Lesson::with('quizzes')->find($id);
        if (!$lesson) {
            return response()->json(['status' => 'error', 'message' => 'Lesson not found'], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $lesson
        ]);
    }

    public function progress(Request $request)
    {
        // Placeholder for student progress
        return response()->json([
            'status' => 'success',
            'data' => [
                'completed_lessons' => 5,
                'total_score' => 450,
                'recent_results' => []
            ]
        ]);
    }
}
