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
}
