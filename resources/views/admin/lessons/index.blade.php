@extends('layouts.admin')

@section('title', 'Lessons')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Lessons</h3>
    <a href="{{ route('lessons.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Lesson</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">Day</th>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Level / Course</th>
                        <th class="px-4 py-3">Video</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lessons as $lesson)
                    <tr>
                        <td class="px-4 py-3">Day {{ $lesson->day_number }}</td>
                        <td class="px-4 py-3 fw-medium">{{ $lesson->title }}</td>
                        <td class="px-4 py-3">{{ $lesson->level->name }} / {{ $lesson->level->course->title }}</td>
                        <td class="px-4 py-3">
                            @if($lesson->video_url)
                                <a href="{{ $lesson->video_url }}" target="_blank"><i class="fab fa-youtube text-danger"></i> Link</a>
                            @else
                                <span class="text-muted">No Video</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('lessons.edit', $lesson) }}" class="btn btn-sm btn-outline-primary me-2"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
