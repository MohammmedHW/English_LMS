<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Admin can only view levels, not edit/delete/create as per requirements.
        $levels = Level::with('courses')->get();
        return view('admin.levels.index', compact('levels'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Level $level)
    {
        $level->load('courses.lessons');
        return view('admin.levels.show', compact('level'));
    }
}
