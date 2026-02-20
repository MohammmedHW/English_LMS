<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = User::where('role', 'student')->count();
        // Since subscription concept is changed to enrollment/login, 
        // activeSubscriptions can be active users in the last month or similar if needed.
        // For now, let's keep it simple or remove it if not relevant.
        // Or simply count verified students.
        $activeStudents = User::where('role', 'student')->whereNotNull('email_verified_at')->count();

        return view('admin.dashboard', compact(
            'totalStudents',
            'activeStudents'
        ));
    }
}
