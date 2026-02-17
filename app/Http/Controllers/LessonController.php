<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Level;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::with('level.course')->get();
        return view('admin.lessons.index', compact('lessons'));
    }

    public function create()
    {
        $levels = Level::with('course')->get();
        return view('admin.lessons.create', compact('levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_id' => 'required|exists:levels,id',
            'day_number' => 'required|integer',
            'title' => 'required|string|max:255',
            'video_url' => 'nullable|url',
        ]);

        Lesson::create($request->all());

        return redirect()->route('lessons.index')->with('success', 'Lesson created successfully.');
    }

    public function edit(Lesson $lesson)
    {
        $levels = Level::with('course')->get();
        return view('admin.lessons.edit', compact('lesson', 'levels'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'level_id' => 'required|exists:levels,id',
            'day_number' => 'required|integer',
            'title' => 'required|string|max:255',
            'video_url' => 'nullable|url',
        ]);

        $lesson->update($request->all());

        return redirect()->route('lessons.index')->with('success', 'Lesson updated successfully.');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('lessons.index')->with('success', 'Lesson deleted successfully.');
    }
}
