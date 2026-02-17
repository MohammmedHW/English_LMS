<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = \App\Models\Student::count();
        $totalCourses = \App\Models\Course::count();
        $totalLessons = \App\Models\Lesson::count();
        $activeSubscriptions = \App\Models\Student::where('status', 'active')->count();

        return view('admin.dashboard', compact(
            'totalStudents', 
            'totalCourses', 
            'totalLessons', 
            'activeSubscriptions'
        ));
    }
}
