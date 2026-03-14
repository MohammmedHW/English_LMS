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

    public function getLevelData(Request $request, $level_name)
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
        $userId = $request->user() ? $request->user()->id : 0;

        // Process days and lessons
        if (isset($data['days']) && is_array($data['days'])) {
            foreach ($data['days'] as &$day) {
                $currentDay = $day['day'] ?? 1;
                // Requested logic: 20 base, +5 every 5 days, max 45
                // However, user said "every 5 consecutive days", which translates to:
                // days 1-5: 20
                // days 6-10: 25
                // days 11-15: 30
                // etc.
                $numQuestions = (int) min(45, 20 + floor(($currentDay - 1) / 5) * 5);

                if (isset($day['lessons']) && is_array($day['lessons'])) {
                    foreach ($day['lessons'] as &$lesson) {
                        $lessonId = $lesson['lessonId'] ?? 0;
                        if (isset($lesson['questions']) && is_array($lesson['questions'])) {
                            
                            $questions = $lesson['questions'];
                            $groupedQuestions = [];

                            // 1. Group by type
                            foreach ($questions as $q) {
                                $type = $q['type'] ?? 'unknown';
                                if (!isset($groupedQuestions[$type])) {
                                    $groupedQuestions[$type] = [];
                                }
                                $groupedQuestions[$type][] = $q;
                            }

                            // 2. Deterministic sort for each group
                            foreach ($groupedQuestions as $type => &$group) {
                                usort($group, function($a, $b) use ($userId, $lessonId) {
                                    $hashA = md5($userId . '_' . $lessonId . '_' . ($a['id'] ?? ''));
                                    $hashB = md5($userId . '_' . $lessonId . '_' . ($b['id'] ?? ''));
                                    return strcmp($hashA, $hashB);
                                });
                            }
                            unset($group);

                            // 3. Round-robin selection
                            $selectedQuestions = [];
                            $types = array_keys($groupedQuestions);
                            $typeCount = count($types);
                            $typeIndex = 0;
                            
                            while (count($selectedQuestions) < $numQuestions && count($groupedQuestions) > 0) {
                                // Re-index types in case one was emptied
                                $types = array_keys($groupedQuestions);
                                if (empty($types)) break;
                                
                                $typeIndex = $typeIndex % count($types);
                                $currentType = $types[$typeIndex];
                                
                                // Pop a question from this type's array
                                $selectedQuestions[] = array_shift($groupedQuestions[$currentType]);
                                
                                // If array is empty, remove the type
                                if (empty($groupedQuestions[$currentType])) {
                                    unset($groupedQuestions[$currentType]);
                                } else {
                                    $typeIndex++;
                                }
                            }

                            // 4. Final deterministic mix of the selected questions
                            // We use a different salt so they don't clump by type
                            usort($selectedQuestions, function($a, $b) use ($userId, $lessonId) {
                                $hashA = md5('final_' . $userId . '_' . $lessonId . '_' . ($a['id'] ?? ''));
                                $hashB = md5('final_' . $userId . '_' . $lessonId . '_' . ($b['id'] ?? ''));
                                return strcmp($hashA, $hashB);
                            });

                            $lesson['questions'] = $selectedQuestions;
                        }
                    }
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
