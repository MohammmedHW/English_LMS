@extends('layouts.admin')

@section('title', 'Manage Subscription Plans')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Subscription Plans</h1>
            <p class="text-muted">Manage the pricing and duration of your subscription tiers.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-uppercase small fw-bold text-muted">Plan Name</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Duration (Days)</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Price</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Description</th>
                        <th class="px-4 py-3 text-end text-uppercase small fw-bold text-muted">Actions</th>
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
                        <td class="py-3">
                            <span class="text-muted small">{{ Str::limit($plan->description, 50) }}</span>
                        </td>
                        <td class="px-4 py-3 text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-sm btn-light border rounded-3 px-3 shadow-none">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <form action="{{ route('plans.destroy', $plan->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-3 shadow-none">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">No plans found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
