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
        $student = $request->user();
        $results = \App\Models\Result::where('student_id', $student->id)->with('lesson')->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'completed_lessons' => $results->count(),
                'total_score' => $results->sum('score'),
                'recent_results' => $results
            ]
        ]);
    }

    public function storeResult(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'score' => 'required|integer',
        ]);

        $student = $request->user();

        $result = \App\Models\Result::updateOrCreate(
            ['student_id' => $student->id, 'lesson_id' => $request->lesson_id],
            ['score' => $request->score]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Result saved successfully',
            'data' => $result
        ]);
    }
}
