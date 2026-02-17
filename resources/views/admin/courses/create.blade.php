@extends('layouts.admin')

@section('title', 'Add Course')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Add New Course</div>
            <div class="card-body">
                <form action="{{ route('courses.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Duration (Days)</label>
                            <select name="duration_days" class="form-select" required>
                                <option value="90">90 Days</option>
                                <option value="180">180 Days</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Price ($)</label>
                            <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Create Course</button>
                        <a href="{{ route('courses.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
