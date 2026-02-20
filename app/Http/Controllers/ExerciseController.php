<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Display exercises for a specific lesson.
     */
    public function index(Lesson $lesson)
    {
        $exercises = $lesson->exercises()->with('question')->orderBy('order')->get();
        return view('admin.exercises.index', compact('lesson', 'exercises'));
    }

    /**
     * Show the form for creating new exercises (multi-add).
     */
    public function create(Lesson $lesson)
    {
        return view('admin.exercises.create', compact('lesson'));
    }

    /**
     * Store multiple exercises at once.
     */
    public function store(Request $request, Lesson $lesson)
    {
        $request->validate([
            'questions'            => 'required|array|min:1',
            'questions.*.type'     => 'required|in:Multiple Choice,Complete the Sentence,Match the Pair,Fill in the Blank,True/False',
            'questions.*.question' => 'required|string|max:2000',
            'questions.*.answer'   => 'required|string|max:1000',
            'questions.*.options'  => 'nullable|array',
            'questions.*.options.*' => 'nullable|string|max:500',
        ]);

        $saved = 0;
        $nextOrder = ($lesson->exercises()->max('order') ?? 0) + 1;
        
        foreach ($request->input('questions') as $i => $qData) {
            $type    = $qData['type'];
            $options = null;

            // Build options payload based on type
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
            // True/False and Fill in the Blank have no options

            // Create Question record
            $question = Question::create([
                'type'     => $type,
                'question' => trim($qData['question']),
                'options'  => $options,
                'answer'   => trim($qData['answer']),
            ]);

            // Link to Lesson via Exercise
            Exercise::create([
                'lesson_id'   => $lesson->id,
                'question_id' => $question->id,
                'order'       => $nextOrder++,
            ]);

            $saved++;
        }

        return redirect()
            ->route('lessons.exercises.index', $lesson)
            ->with('success', $saved . ' exercise' . ($saved !== 1 ? 's' : '') . ' added successfully!');
    }

    /**
     * Show the form for editing the specified exercise.
     */
    public function edit(Exercise $exercise)
    {
        $exercise->load('question');
        return view('admin.exercises.edit', compact('exercise'));
    }

    /**
     * Update the specified exercise in storage.
     */
    public function update(Request $request, Exercise $exercise)
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

        $exercise->question->update([
            'type'     => $type,
            'question' => trim($request->question),
            'options'  => $options,
            'answer'   => trim($request->answer),
        ]);

        return redirect()
            ->route('lessons.exercises.index', $exercise->lesson_id)
            ->with('success', 'Exercise updated successfully.');
    }

    /**
     * Remove the specified exercise from storage.
     */
    public function destroy(Exercise $exercise)
    {
        $lessonId = $exercise->lesson_id;
        $question = $exercise->question;
        $exercise->delete();
        if ($question) {
            $question->delete();
        }

        return redirect()
            ->route('lessons.exercises.index', $lessonId)
            ->with('success', 'Exercise deleted successfully.');
    }
}
