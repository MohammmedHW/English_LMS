<?php

namespace App\Http\Controllers;

use App\Models\TestQuestion;
use App\Models\Lesson;
use App\Models\Test;
use App\Models\Question;
use Illuminate\Http\Request;

class TestQuestionController extends Controller
{
    /**
     * Display test questions for a specific lesson's test.
     */
    public function index(Lesson $lesson)
    {
        $test      = $lesson->test ?? Test::create(['lesson_id' => $lesson->id]);
        $questions = $test->questions()->with('question')->orderBy('order')->get();
        return view('admin.test_questions.index', compact('lesson', 'test', 'questions'));
    }

    /**
     * Show the form for creating new test questions (multi-add).
     */
    public function create(Lesson $lesson)
    {
        $test = $lesson->test ?? Test::create(['lesson_id' => $lesson->id]);
        return view('admin.test_questions.create', compact('lesson', 'test'));
    }

    /**
     * Store multiple test questions at once.
     */
    public function store(Request $request, Lesson $lesson)
    {
        $request->validate([
            'questions'              => 'required|array|min:1',
            'questions.*.type'       => 'required|in:Multiple Choice,Complete the Sentence,Match the Pair,Fill in the Blank,True/False',
            'questions.*.question'   => 'required|string|max:2000',
            'questions.*.answer'     => 'required|string|max:1000',
            'questions.*.options'    => 'nullable|array',
            'questions.*.options.*'  => 'nullable|string|max:500',
        ]);

        // Ensure a Test record exists for this lesson
        $test = $lesson->test ?? Test::create(['lesson_id' => $lesson->id]);

        $saved = 0;
        $nextOrder = ($test->questions()->max('order') ?? 0) + 1;
        
        foreach ($request->input('questions') as $i => $qData) {
            $type    = $qData['type'];
            $options = null;

            if ($type === 'Match the Pair') {
                $pairs  = [];
                $lefts  = $qData['pairs']['left']  ?? [];
                $rights = $qData['pairs']['right'] ?? [];
                foreach ($lefts as $idx => $left) {
                    if (!empty(trim($left))) {
                        $pairs[] = ['left' => trim($left), 'right' => trim($rights[$idx] ?? '')];
                    }
                }
                $options = count($pairs) ? $pairs : null;

            } elseif (in_array($type, ['Multiple Choice', 'Complete the Sentence'])) {
                $filtered = array_values(
                    array_filter($qData['options'] ?? [], fn($o) => trim($o) !== '')
                );
                $options = count($filtered) ? $filtered : null;
            }

            $question = Question::create([
                'type'     => $type,
                'question' => trim($qData['question']),
                'options'  => $options,
                'answer'   => trim($qData['answer']),
            ]);

            TestQuestion::create([
                'test_id'     => $test->id,
                'question_id' => $question->id,
                'order'       => $nextOrder++,
            ]);

            $saved++;
        }

        return redirect()
            ->route('lessons.test_questions.index', $lesson)
            ->with('success', $saved . ' question' . ($saved !== 1 ? 's' : '') . ' added to the test!');
    }

    /**
     * Show the form for editing the specified test question.
     */
    public function edit(TestQuestion $testQuestion)
    {
        $testQuestion->load('question');
        return view('admin.test_questions.edit', compact('testQuestion'));
    }

    /**
     * Update the specified test question in storage.
     */
    public function update(Request $request, TestQuestion $testQuestion)
    {
        $request->validate([
            'type'     => 'required|in:Multiple Choice,Complete the Sentence,Match the Pair,Fill in the Blank,True/False',
            'question' => 'required|string|max:2000',
            'answer'   => 'required|string|max:1000',
            'options'  => 'nullable|array',
        ]);

        $type = $request->type;
        $options = null;

        if ($type === 'Match the Pair') {
            $pairs = [];
            $lefts = $request->input('pairs.left') ?? [];
            $rights = $request->input('pairs.right') ?? [];
            foreach ($lefts as $idx => $left) {
                if (!empty(trim($left))) {
                    $pairs[] = ['left' => trim($left), 'right' => trim($rights[$idx] ?? '')];
                }
            }
            $options = count($pairs) ? $pairs : null;
        } elseif (in_array($type, ['Multiple Choice', 'Complete the Sentence'])) {
            $filtered = array_values(
                array_filter($request->input('options') ?? [], fn($o) => trim($o) !== '')
            );
            $options = count($filtered) ? $filtered : null;
        }

        $testQuestion->question->update([
            'type'     => $type,
            'question' => trim($request->question),
            'options'  => $options,
            'answer'   => trim($request->answer),
        ]);

        return redirect()
            ->route('lessons.test_questions.index', $testQuestion->test->lesson_id)
            ->with('success', 'Test Question updated successfully.');
    }

    /**
     * Remove the specified test question from storage.
     */
    public function destroy(TestQuestion $testQuestion)
    {
        $lessonId = $testQuestion->test->lesson_id;
        $question = $testQuestion->question;
        $testQuestion->delete();
        if ($question) {
            $question->delete();
        }

        return redirect()
            ->route('lessons.test_questions.index', $lessonId)
            ->with('success', 'Test Question deleted successfully.');
    }
}
