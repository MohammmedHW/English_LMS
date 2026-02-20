@extends('layouts.admin')

@section('title', 'Manage Courses')

@section('content')
<div class="fade-in">
    <!-- Page Header -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-8">
            <h1 class="display-6 mb-2">Courses</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active">Courses</li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-4 text-lg-end">
            <a href="{{ route('courses.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i> Create New Course
            </a>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom-0 py-4 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Active Courses</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted small font-outfit text-uppercase tracking-wider">Course Title</th>
                        <th class="py-3 text-muted small font-outfit text-uppercase tracking-wider">Level</th>
                        <th class="py-3 text-muted small font-outfit text-uppercase tracking-wider">Lessons</th>
                        <th class="pe-4 py-3 text-muted small font-outfit text-uppercase tracking-wider text-end">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                    <tr>
                        <td class="ps-4 py-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 44px; height: 44px; background: var(--primary-soft); color: var(--primary);">
                                    <i class="fas fa-book-sparkles"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark ">{{ $course->title }}</div>
                                    <div class="text-muted small">{{ Str::limit($course->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-soft-primary">
                                <i class="fas fa-layer-group me-1"></i> {{ $course->level->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-soft-success">
                                <i class="fas fa-circle-play me-1"></i> {{ $course->lessons->count() }}
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('courses.edit', $course) }}" class="btn btn-icon btn-light" title="Edit">
                                    <i class="fas fa-pen-to-square text-muted"></i>
                                </a>
                                <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-light" title="Delete" onclick="return confirm('Are you sure you want to delete this course?')">
                                        <i class="fas fa-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <i class="fas fa-box-open d-block fs-1 text-muted mb-3"></i>
                            <p class="text-muted">No courses found. Start by creating one!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-top-0 py-4 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">Showing {{ $courses->count() }} courses</div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-color);
        background: white;
        transition: all 0.2s;
    }
    .btn-icon:hover {
        background: #f8fafc;
        transform: translateY(-2px);
    }
    .tracking-wider {
        letter-spacing: 0.05em;
    }
</style>
@endsection
