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
});
