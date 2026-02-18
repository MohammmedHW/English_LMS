<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $student = Student::where('email', $request->email)->first();

        if (!$student || !Hash::check($request->password, $student->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $student->createToken('student_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'student' => $student
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'course_id' => 'required|exists:courses,id',
        ]);

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'course_id' => $request->course_id,
            'subscription_start' => now(),
            'subscription_end' => now()->addDays(90), 
            'status' => 'active',
        ]);

        $token = $student->createToken('student_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Student registered successfully',
            'token' => $token,
            'student' => $student
        ], 201);
    }
}
