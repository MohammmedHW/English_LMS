<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function listLevels()
    {
        $files = Storage::disk('local')->files('lessons');
        $levels = array_map(function ($file) {
            return str_replace(['lessons/', '.json'], '', $file);
        }, $files);

        return response()->json([
            'status' => 'success',
            'data' => $levels
        ]);
    }

    public function getLevelData($level_name)
    {
        $path = "lessons/{$level_name}.json";

        if (!Storage::disk('local')->exists($path)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Level data not found'
            ], 404);
        }

        $data = json_decode(Storage::disk('local')->get($path), true);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
