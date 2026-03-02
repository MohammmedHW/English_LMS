<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up(): void    {
        $freePlanId = DB::table('subscription_plans')
            ->where('name', 'Free')
            ->value('id');

        if (!$freePlanId) {
            throw new Exception('Free plan not found in subscription_plans table.');
        }

        // 1️⃣ First update NULL values
        DB::table('users')
            ->whereNull('subscription_plan_id')
            ->update([
            'subscription_plan_id' => $freePlanId
        ]);

        // 2️⃣ Then modify column
        Schema::table('users', function (Blueprint $table) use ($freePlanId) {
            $table->unsignedBigInteger('subscription_plan_id')
                ->default($freePlanId)
                ->nullable(false)
                ->change();
        });    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('subscription_plan_id')->default(null)->change();
        });
    }
};
