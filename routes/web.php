<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\TestQuestionController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Levels (Read Only mostly, but listing)
    Route::resource('levels', LevelController::class)->only(['index', 'show']);

    // Courses
    Route::resource('courses', CourseController::class);

    // Lessons
    Route::resource('lessons', LessonController::class);

    // Exercises (Nested under Lessons)
    Route::resource('lessons.exercises', ExerciseController::class)->shallow();

    // Test Questions (Nested under Lessons)
    Route::resource('lessons.test_questions', TestQuestionController::class)->shallow();

    // Students (Users)
    Route::resource('students', StudentController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Fix Route (Dev only)
Route::get('/fix-admin', function () {
    $user = User::where('email', 'admin@gmail.com')->first();
    if (!$user) return 'User not found';
    $user->password = Hash::make('123456');
    $user->save();
    return 'Password Updated Successfully';
});

require __DIR__.'/auth.php';
