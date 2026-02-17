@extends('layouts.admin')

@section('title', 'Add Lesson')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Add New Lesson</div>
            <div class="card-body">
                <form action="{{ route('lessons.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Level / Course</label>
                        <select name="level_id" class="form-select @error('level_id') is-invalid @enderror" required>
                            <option value="">Select Level</option>
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}">{{ $level->name }} ({{ $level->course->title }})</option>
                            @endforeach
                        </select>
                        @error('level_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Day Number</label>
                            <input type="number" name="day_number" class="form-control" value="1" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Video URL (YouTube)</label>
                        <input type="url" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Create Lesson</button>
                        <a href="{{ route('lessons.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
