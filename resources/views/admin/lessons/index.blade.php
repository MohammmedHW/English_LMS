@extends('layouts.admin')

@section('title', 'Lessons')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Lessons</h3>
    <a href="{{ route('lessons.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Lesson</a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">Order</th>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Course / Level</th>
                        <th class="px-4 py-3">Pass Score</th>
                        <th class="px-4 py-3 text-end">Manage Content</th>
                        <th class="px-4 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lessons as $lesson)
                    <tr>
                        <td class="px-4 py-3 text-muted">#{{ $lesson->order }}</td>
                        <td class="px-4 py-3 fw-bold">{{ $lesson->title }}</td>
                        <td class="px-4 py-3">
                            <div class="fw-semibold">{{ $lesson->course->title }}</div>
                            <div class="small text-muted">{{ $lesson->course->level->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="badge badge-soft-primary">{{ $lesson->pass_score }}%</span>
                        </td>
                        <td class="px-4 py-3 text-end">
                            <a href="{{ route('lessons.exercises.index', $lesson) }}" class="btn btn-sm btn-outline-success me-1" title="Practice Exercises">
                                <i class="fas fa-dumbell"></i> Exercises
                            </a>
                            <a href="{{ route('lessons.test_questions.index', $lesson) }}" class="btn btn-sm btn-outline-warning" title="Final Test">
                                <i class="fas fa-file-signature"></i> Test
                            </a>
                        </td>
                        <td class="px-4 py-3 text-end">
                            <a href="{{ route('lessons.edit', $lesson) }}" class="btn btn-sm btn-light text-muted me-2" title="Edit"><i class="fas fa-pen"></i></a>
                            <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger" title="Delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">No lessons found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
