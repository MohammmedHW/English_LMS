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
    public function up(): void
    {
        // 1. Get the 'Free' plan ID
        $freePlanId = DB::table('subscription_plans')->where('name', 'Free')->value('id');

        if ($freePlanId) {
            // 2. Set default for the column (MySQL/PostgreSQL specific syntax via raw or standard)
            Schema::table('users', function (Blueprint $table) use ($freePlanId) {
                $table->unsignedBigInteger('subscription_plan_id')->default($freePlanId)->change();
            });

            // 3. Update existing users who have null
            DB::table('users')->whereNull('subscription_plan_id')->update([
                'subscription_plan_id' => $freePlanId
            ]);
        }
    }

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
