@extends('layouts.admin')

@section('title', 'Edit Course')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h5 class="mb-0 fw-bold">Edit Course: {{ $course->title }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('courses.update', $course) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Level</label>
                        <select name="level_id" class="form-select @error('level_id') is-invalid @enderror" required>
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}" {{ $course->level_id == $level->id ? 'selected' : '' }}>
                                    {{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('level_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Course Title</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $course->title }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="4">{{ $course->description }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Cover Image URL (Optional)</label>
                        <input type="text" name="image" class="form-control @error('image') is-invalid @enderror" value="{{ $course->image }}">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('courses.index') }}" class="btn btn-light me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Update Course</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
