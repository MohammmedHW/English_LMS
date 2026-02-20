<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\LessonResult;
use App\Models\Exercise;
use App\Models\Test;
use App\Models\UserAnswer;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Get lessons for a course with lock status
     */
    public function index($course_id)
    {
        $user = auth()->user();
        $lessons = Lesson::where('course_id', $course_id)->orderBy('order')->get();
        
        $prevPassed = true; // First lesson is always unlocked
        
        foreach ($lessons as $lesson) {
            $result = LessonResult::where('user_id', $user->id)
                ->where('lesson_id', $lesson->id)
                ->first();
            
            $lesson->is_unlocked = $prevPassed;
            $lesson->is_completed = $result ? $result->is_passed : false;
            $lesson->last_result = $result;
            
            $prevPassed = $lesson->is_completed;
        }

        return response()->json([
            'status' => 'success',
            'data' => $lessons
        ]);
    }

    /**
     * Get Exercises for Practice Mode
     */
    public function getExercises($id)
    {
        $lesson = Lesson::findOrFail($id);
        
        // Check if unlocked (optional but good for security)
        // ...

        $exercises = Exercise::where('lesson_id', $id)
            ->with('question')
            ->orderBy('order')
            ->get()
            ->pluck('question');

        return response()->json([
            'status' => 'success',
            'data' => $exercises
        ]);
    }

    /**
     * Mark Exercises as completed to unlock the Final Test
     */
    public function completeExercises($id)
    {
        $user = auth()->user();
        
        $result = LessonResult::updateOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $id],
            ['exercises_completed' => true, 'test_locked' => false]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Exercises completed. Final test unlocked!',
            'data' => $result
        ]);
    }

    /**
     * Get Final Test Questions
     */
    public function getTest($id)
    {
        $user = auth()->user();
        $result = LessonResult::where('user_id', $user->id)
            ->where('lesson_id', $id)
            ->first();

        if (!$result || !$result->exercises_completed) {
            return response()->json([
                'status' => 'error',
                'message' => 'You must complete exercises before taking the test.'
            ], 403);
        }

        if ($result->test_locked) {
            return response()->json([
                'status' => 'error',
                'message' => 'Test is locked. Please revise the lesson.'
            ], 403);
        }

        $test = Test::where('lesson_id', $id)->with('questions.question')->first();
        
        if (!$test) {
            return response()->json([
                'status' => 'error',
                'message' => 'Test not found for this lesson.'
            ], 404);
        }

        $questions = $test->questions->pluck('question');

        return response()->json([
            'status' => 'success',
            'data' => $questions
        ]);
    }

    /**
     * Submit Final Test
     */
    public function submitTest(Request $request, $id)
    {
        $user = auth()->user();
        $lesson = Lesson::findOrFail($id);
        $test = Test::where('lesson_id', $id)->first();
        
        if (!$test) return response()->json(['status' => 'error', 'message' => 'Test not found'], 404);

        $answers = $request->input('answers'); // Expecting [question_id => answer]
        
        $totalQuestions = $test->questions()->count();
        if ($totalQuestions == 0) return response()->json(['status' => 'error', 'message' => 'Test has no questions'], 400);

        $correctCount = 0;
        
        // Clear previous answers for this attempt if exists? 
        // User can submit ONLY ONCE per unlock.
        
        UserAnswer::where('user_id', $user->id)->where('lesson_id', $id)->delete();

        foreach ($test->questions as $tq) {
            $submitted = $answers[$tq->question_id] ?? null;
            $isCorrect = ($submitted == $tq->question->answer);
            if ($isCorrect) $correctCount++;

            UserAnswer::create([
                'user_id' => $user->id,
                'lesson_id' => $id,
                'test_question_id' => $tq->id,
                'answer' => $submitted,
                'is_correct' => $isCorrect
            ]);
        }

        $score = ($correctCount / $totalQuestions) * 100;
        $isPassed = $score >= $lesson->pass_score;

        $result = LessonResult::updateOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $id],
            [
                'score' => $score,
                'is_passed' => $isPassed,
                'test_locked' => true // Lockdown test after submission
            ]
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'score' => $score,
                'is_passed' => $isPassed,
                'pass_score' => $lesson->pass_score,
                'message' => $isPassed ? 'Congratulations! You passed!' : 'You failed. Please revise the lesson.'
            ]
        ]);
    }
}
