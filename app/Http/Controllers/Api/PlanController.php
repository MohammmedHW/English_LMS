<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => SubscriptionPlan::all()
        ]);
    }

    public function current(Request $request)
    {
        $user = $request->user();
        $user->load('subscriptionPlan');

        return response()->json([
            'status' => 'success',
            'data' => [
                'plan' => $user->subscriptionPlan,
                'expires_at' => $user->subscription_expires_at,
                'is_active' => $user->subscription_expires_at ? now()->lessThan($user->subscription_expires_at) : false
            ]
        ]);
    }

    public function upgrade(Request $request)
    {
        $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $user = $request->user();
        $plan = SubscriptionPlan::find($request->subscription_plan_id);

        // Calculate expiry date based on plan duration
        $expiresAt = $plan->duration_days > 0
            ? now()->addDays($plan->duration_days)
            : null;

        $user->subscription_plan_id = $plan->id;
        $user->subscription_expires_at = $expiresAt;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription upgraded successfully to ' . $plan->name,
            'user' => $user->load('subscriptionPlan')
        ]);
    }
}
