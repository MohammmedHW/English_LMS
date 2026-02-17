<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;

Route::get('/courses', [CourseController::class, 'index']);
Route::get('/levels/{course_id}', [CourseController::class, 'levels']);
Route::get('/lessons/{level_id}', [LessonController::class, 'index']);
Route::get('/lesson-details/{id}', [LessonController::class, 'show']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/student-progress', [LessonController::class, 'progress'])->middleware('auth:sanctum');
