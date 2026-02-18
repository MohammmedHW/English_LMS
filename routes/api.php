<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;

use App\Http\Controllers\Api\StudentController;

Route::get('/courses', [CourseController::class, 'index']);
Route::get('/levels/{course_id}', [CourseController::class, 'levels']);
Route::get('/lessons/{level_id}', [LessonController::class, 'index']);
Route::get('/lesson-details/{id}', [LessonController::class, 'show']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/student-progress', [LessonController::class, 'progress']);
    Route::post('/submit-result', [LessonController::class, 'storeResult']);
    Route::get('/profile', [StudentController::class, 'profile']);
    Route::put('/update-profile', [StudentController::class, 'updateProfile']);
});
