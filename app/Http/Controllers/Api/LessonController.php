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
        // Normalize: lowercase, hyphens and spaces to underscores
        $normalizedName = str_replace(['-', ' '], '_', strtolower($level_name));

        $paths = [
            "lessons/{$normalizedName}.json",
            "lessons/{$normalizedName}_level.json"
        ];

        $foundPath = null;
        foreach ($paths as $path) {
            if (Storage::disk('local')->exists($path)) {
                $foundPath = $path;
                break;
            }
        }

        if (!$foundPath) {
            return response()->json([
                'status' => 'error',
                'message' => "Level data not found for: {$level_name} (checked: " . implode(', ', $paths) . ")"
            ], 404);
        }

        $data = json_decode(Storage::disk('local')->get($foundPath), true);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
