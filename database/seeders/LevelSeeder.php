<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = ['Junior', 'School', 'College'];
        foreach ($levels as $level) {
            Level::updateOrCreate(['name' => $level]);
        }
    }
}
