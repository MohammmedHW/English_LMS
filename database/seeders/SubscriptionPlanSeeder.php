<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free',
                'duration_days' => 0,
                'price' => 0.00,
                'description' => 'Access to basic lessons and limited features.',
            ],
            [
                'name' => '90 Days Plan',
                'duration_days' => 90,
                'price' => 49.99,
                'description' => 'Unlimited access for 90 days.',
            ],
            [
                'name' => '180 Days Plan',
                'duration_days' => 180,
                'price' => 89.99,
                'description' => 'Unlimited access for 180 days.',
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(['name' => $plan['name']], $plan);
        }
    }
}
