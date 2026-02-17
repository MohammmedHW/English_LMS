@extends('layouts.admin')

@section('title', 'Add Level')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Add New Level</div>
            <div class="card-body">
                <form action="{{ route('levels.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Course</label>
                        <select name="course_id" class="form-select @error('course_id') is-invalid @enderror" required>
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                        @error('course_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Junior, School, College" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Create Level</button>
                        <a href="{{ route('levels.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
