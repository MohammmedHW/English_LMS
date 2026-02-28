<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::all();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        SubscriptionPlan::create($request->all());

        return redirect()->route('plans.index')->with('success', 'Subscription plan created successfully.');
    }

    public function edit(SubscriptionPlan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, SubscriptionPlan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $plan->update($request->all());

        return redirect()->route('plans.index')->with('success', 'Subscription plan updated successfully.');
    }

    public function destroy(SubscriptionPlan $plan)
    {
        $plan->delete();
        return redirect()->route('plans.index')->with('success', 'Subscription plan deleted successfully.');
    }
}
