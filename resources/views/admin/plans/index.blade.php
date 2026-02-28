@extends('layouts.admin')

@section('title', 'Subscription Plans')

@section('content')
<div class="fade-in">
    <div class="mb-4">
        <h1 class="h3 mb-1">Subscription Plans</h1>
        <p class="text-muted">Available subscription tiers for students.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-uppercase small fw-bold text-muted">Plan Name</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Duration (Days)</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Price</th>
                        <th class="px-4 py-3 text-uppercase small fw-bold text-muted">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                    <tr>
                        <td class="px-4 py-3">
                            <span class="fw-bold text-dark">{{ $plan->name }}</span>
                        </td>
                        <td class="py-3">
                            {{ $plan->duration_days == 0 ? 'Unlimited' : $plan->duration_days . ' Days' }}
                        </td>
                        <td class="py-3">
                            <span class="badge {{ $plan->price == 0 ? 'bg-success' : 'bg-primary' }} rounded-pill px-3">
                                {{ $plan->price == 0 ? 'Free' : '$' . number_format($plan->price, 2) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-muted small">{{ $plan->description }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">No plans found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
