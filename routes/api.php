<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\StudentController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/levels', [CourseController::class, 'levels']);
Route::get('/courses/{level_id}', [CourseController::class, 'index']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/lessons/{course_id}', [LessonController::class, 'index']);
    Route::get('/lesson/{id}/exercises', [LessonController::class, 'getExercises']);
    Route::post('/lesson/{id}/complete-exercises', [LessonController::class, 'completeExercises']);
    Route::get('/lesson/{id}/test', [LessonController::class, 'getTest']);
    Route::post('/lesson/{id}/submit-test', [LessonController::class, 'submitTest']);

    Route::get('/profile', [StudentController::class, 'profile']);
    Route::put('/update-profile', [StudentController::class, 'updateProfile']);
});
