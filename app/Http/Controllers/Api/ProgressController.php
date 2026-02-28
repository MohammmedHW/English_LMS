<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserProgress;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function index(Request $request)
    {
        $progress = $request->user()->progress;

        return response()->json([
            'status' => 'success',
            'data' => $progress
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'level_name' => 'required|string',
            'day' => 'required|integer',
            'is_completed' => 'required|boolean',
            'score' => 'nullable|integer',
        ]);

        $progress = UserProgress::updateOrCreate(
        [
            'user_id' => $request->user()->id,
            'level_name' => $request->level_name,
            'day' => $request->day,
        ],
        [
            'is_completed' => $request->is_completed,
            'score' => $request->score ?? 0,
        ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Progress updated',
            'data' => $progress
        ]);
    }
}
