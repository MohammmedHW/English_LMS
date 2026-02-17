<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default Admin
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('123456'),
                'role' => 'admin',
            ]
        );

        // 1 Demo Course
        $course = \App\Models\Course::create([
            'title' => 'General English',
            'duration_days' => 90,
            'price' => 29.99,
            'description' => 'A comprehensive course for beginners.',
        ]);

        // 1 Level (Junior)
        $level = \App\Models\Level::create([
            'course_id' => $course->id,
            'name' => 'Junior',
        ]);

        // 3 Sample Lessons
        \App\Models\Lesson::create([
            'level_id' => $level->id,
            'day_number' => 1,
            'title' => 'Introduction to English',
            'description' => 'Basics of English language.',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'notes' => 'Note for lesson 1',
        ]);

        \App\Models\Lesson::create([
            'level_id' => $level->id,
            'day_number' => 2,
            'title' => 'Alphabet and Sounds',
            'description' => 'Learning the alphabet.',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'notes' => 'Note for lesson 2',
        ]);

        \App\Models\Lesson::create([
            'level_id' => $level->id,
            'day_number' => 3,
            'title' => 'Basic Greetings',
            'description' => 'How to say hello.',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'notes' => 'Note for lesson 3',
        ]);
    }
}
