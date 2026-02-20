<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalCourses = Course::count();
        $totalLessons = Lesson::count();
        // Since subscription concept is changed to enrollment/login, 
        // activeSubscriptions can be active users in the last month or similar if needed.
        // For now, let's keep it simple or remove it if not relevant.
        // Or simply count verified students.
        $activeStudents = User::where('role', 'student')->whereNotNull('email_verified_at')->count();

        return view('admin.dashboard', compact(
            'totalStudents', 
            'totalCourses', 
            'totalLessons', 
            'activeStudents'
        ));
    }
}
