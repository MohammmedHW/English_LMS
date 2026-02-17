<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Course;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::with('course')->get();
        return view('admin.levels.index', compact('levels'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.levels.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
        ]);

        Level::create($request->all());

        return redirect()->route('levels.index')->with('success', 'Level created successfully.');
    }

    public function edit(Level $level)
    {
        $courses = Course::all();
        return view('admin.levels.edit', compact('level', 'courses'));
    }

    public function update(Request $request, Level $level)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
        ]);

        $level->update($request->all());

        return redirect()->route('levels.index')->with('success', 'Level updated successfully.');
    }

    public function destroy(Level $level)
    {
        $level->delete();
        return redirect()->route('levels.index')->with('success', 'Level deleted successfully.');
    }
}
