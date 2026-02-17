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
            <div class="input-group w-25">
                <span class="input-group-text bg-light border-end-0 border-light px-3"><i class="fas fa-search text-muted small"></i></span>
                <input type="text" class="form-control bg-light border-start-0 border-light small px-2" placeholder="Search courses...">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted small font-outfit text-uppercase tracking-wider">Course Info</th>
                        <th class="py-3 text-muted small font-outfit text-uppercase tracking-wider">Duration</th>
                        <th class="py-3 text-muted small font-outfit text-uppercase tracking-wider">Pricing</th>
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
                                    <div class="text-muted small">Updated 2 days ago</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-soft-primary">
                                <i class="fas fa-calendar-alt me-1"></i> {{ $course->duration_days }} Days
                            </span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark fs-5">${{ number_format($course->price, 2) }}</div>
                            <div class="text-muted extra-small fw-bold text-uppercase" style="font-size: 10px;">One-time payment</div>
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
                <div class="small text-muted">All courses are active</div>
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
