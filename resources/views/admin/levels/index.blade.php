@extends('layouts.admin')

@section('title', 'Levels')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Levels</h3>
    {{-- Admin cannot create levels --}}
</div>

<div class="alert alert-info border-0 shadow-sm rounded-4 mb-4">
    <i class="fas fa-info-circle me-2"></i> Levels are predefined and cannot be modified.
</div>

<div class="row g-4">
    @foreach($levels as $level)
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary">
                    <i class="fas fa-layer-group fs-4"></i>
                </div>
                <span class="badge bg-light text-dark border">{{ $level->courses->count() }} Courses</span>
            </div>
            
            <h4 class="mb-2">{{ $level->name }}</h4>
            <p class="text-muted small mb-4">
                Core level containing {{ $level->courses->count() }} courses.
            </p>

            <a href="{{ route('courses.index', ['level_id' => $level->id]) }}" class="btn btn-outline-primary w-100 rounded-3">
                View Courses
            </a>
        </div>
    </div>
    @endforeach
</div>
@endsection
