@extends('layouts.admin')

@section('title', 'Edit Lesson')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h5 class="mb-0 fw-bold">Edit Lesson: {{ $lesson->title }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('lessons.update', $lesson) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Course</label>
                        <select name="course_id" class="form-select @error('course_id') is-invalid @enderror" required>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ $lesson->course_id == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }} ({{ $course->level->name ?? 'No Level' }})
                                </option>
                            @endforeach
                        </select>
                        @error('course_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Lesson Title</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $lesson->title }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Order Sequence</label>
                            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ $lesson->order }}" required>
                            <div class="form-text small text-muted">Determines the order of lessons in the course.</div>
                            @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Passing Score (%)</label>
                            <input type="number" name="pass_score" class="form-control @error('pass_score') is-invalid @enderror" value="{{ $lesson->pass_score }}" min="0" max="100" required>
                            <div class="form-text small text-muted">Score required to unlock the next lesson.</div>
                            @error('pass_score') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('lessons.index') }}" class="btn btn-light me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Update Lesson</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
