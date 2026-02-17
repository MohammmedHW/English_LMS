<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Lesson;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('lesson')->get();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $lessons = Lesson::all();
        return view('admin.quizzes.create', compact('lessons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);

        Quiz::create($request->all());

        return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully.');
    }

    public function edit(Quiz $quiz)
    {
        $lessons = Lesson::all();
        return view('admin.quizzes.edit', compact('quiz', 'lessons'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);

        $quiz->update($request->all());

        return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
    }
}
