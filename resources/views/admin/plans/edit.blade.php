@extends('layouts.admin')

@section('title', 'Edit Subscription Plan')

@section('content')
<div class="fade-in">
    <div class="mb-4">
        <a href="{{ route('plans.index') }}" class="btn btn-sm btn-light border rounded-3 px-3 mb-3">
            <i class="fas fa-arrow-left me-2"></i> Back to Plans
        </a>
        <h1 class="h3 mb-1">Edit Plan: {{ $plan->name }}</h1>
        <p class="text-muted">Modify the details of this subscription tier.</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <form action="{{ route('plans.update', $plan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="form-label small fw-bold text-muted text-uppercase">Plan Name</label>
                        <input type="text" class="form-control rounded-3 border @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $plan->name) }}" required placeholder="e.g. Premium Plan">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="duration_days" class="form-label small fw-bold text-muted text-uppercase">Duration (Days)</label>
                            <input type="number" class="form-control rounded-3 border @error('duration_days') is-invalid @enderror" id="duration_days" name="duration_days" value="{{ old('duration_days', $plan->duration_days) }}" required min="0">
                            <div class="form-text small">Enter '0' for unlimited/lifetime access.</div>
                            @error('duration_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="form-label small fw-bold text-muted text-uppercase">Price ($)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">$</span>
                                <input type="number" step="0.01" class="form-control rounded-end-3 border @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $plan->price) }}" required min="0">
                            </div>
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label small fw-bold text-muted text-uppercase">Description</label>
                        <textarea class="form-control rounded-3 border @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $plan->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-light border">
                <h6 class="fw-bold mb-3"><i class="fas fa-info-circle text-primary me-2"></i> Quick Tips</h6>
                <ul class="small text-muted ps-3 mb-0">
                    <li class="mb-2">Updates to plan prices will apply immediately to new subscribers.</li>
                    <li class="mb-2">Setting duration to 0 makes the plan permanent for the user.</li>
                    <li>Clearly describe the benefits of the plan in the description to help students choose.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
