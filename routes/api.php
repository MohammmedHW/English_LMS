<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentController;

// Public routes
Route::post('/login', [AuthController::class , 'login']);
Route::post('/register', [AuthController::class , 'register']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class , 'logout']);

    Route::get('/profile', [StudentController::class , 'profile']);
    Route::put('/update-profile', [StudentController::class , 'updateProfile']);

    // Subscription Plans
    Route::get('/plans', [\App\Http\Controllers\Api\PlanController::class , 'index']);
    Route::get('/plans/current', [\App\Http\Controllers\Api\PlanController::class , 'current']);

    // User Progress
    Route::get('/progress', [\App\Http\Controllers\Api\ProgressController::class , 'index']);
    Route::post('/progress', [\App\Http\Controllers\Api\ProgressController::class , 'update']);

    // Lessons (Static Data)
    Route::get('/levels', [\App\Http\Controllers\Api\LessonController::class , 'listLevels']);
    Route::get('/levels/{level}', [\App\Http\Controllers\Api\LessonController::class , 'getLevelData']);
});
