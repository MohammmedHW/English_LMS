@extends('layouts.admin')

@section('title', 'Student Management')

@section('content')
<div class="fade-in">
    <!-- Page Header -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-8">
            <h1 class="display-6 mb-2">Students</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active">Students</li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-4 text-lg-end">
            <a href="{{ route('students.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i> Register New Student
            </a>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom-0 py-4 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Enrolled Students</h5>
            <div class="input-group w-50">
                <span class="input-group-text bg-light border-end-0 border-light px-3"><i class="fas fa-search text-muted small"></i></span>
                <input type="text" class="form-control bg-light border-start-0 border-light small px-2" placeholder="Search by name, email, or course...">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted small font-outfit text-uppercase tracking-wider">Student Profile</th>
                        <th class="py-3 text-muted small font-outfit text-uppercase tracking-wider">Enrolled Course</th>
                        <th class="py-3 text-muted small font-outfit text-uppercase tracking-wider">Status</th>
                        <th class="pe-4 py-3 text-muted small font-outfit text-uppercase tracking-wider text-end">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr>
                        <td class="ps-4 py-4">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=eef2ff&color=4f46e5&bold=true" class="rounded-circle me-3" width="44" height="44">
                                <div>
                                    <div class="fw-bold text-dark ">{{ $student->name }}</div>
                                    <div class="text-muted small">{{ $student->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $student->course->title ?? 'N/A' }}</div>
                            <div class="text-muted extra-small fw-bold text-uppercase" style="font-size: 10px;">Joined {{ $student->created_at->format('M Y') }}</div>
                        </td>
                        <td>
                            @if($student->status == 'active')
                                <span class="badge badge-soft-success">
                                    <i class="fas fa-circle-check me-1 small"></i> Active
                                </span>
                            @else
                                <span class="badge badge-soft-danger">
                                    <i class="fas fa-circle-xmark me-1 small"></i> Expired
                                </span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-icon btn-light" title="Edit Profile">
                                    <i class="fas fa-user-pen text-muted"></i>
                                </a>
                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-light" title="Delete Account" onclick="return confirm('Are you sure you want to remove this student?')">
                                        <i class="fas fa-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <i class="fas fa-user-slash d-block fs-1 text-muted mb-3"></i>
                            <p class="text-muted">No students registered yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-top-0 py-4 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">Total {{ $students->count() }} registered students</div>
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
    .badge-soft-danger { background: #fef2f2; color: #ef4444; }
</style>
@endsection
