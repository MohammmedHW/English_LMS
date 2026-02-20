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
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted small font-outfit text-uppercase tracking-wider">Student Profile</th>
                        <th class="py-3 text-muted small font-outfit text-uppercase tracking-wider">Contact</th>
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
                                    <div class="text-muted small">Joined {{ $student->created_at->format('M Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="small text-dark mb-1"><i class="fas fa-envelope text-muted me-2"></i> {{ $student->email }}</span>
                                @if($student->phone)
                                    <span class="small text-muted"><i class="fas fa-phone text-muted me-2"></i> {{ $student->phone }}</span>
                                @else
                                    <span class="small text-muted fst-italic"><i class="fas fa-phone-slash text-muted me-2"></i> No Phone</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($student->email_verified_at)
                                <span class="badge badge-soft-success">
                                    <i class="fas fa-circle-check me-1 small"></i> Verified
                                </span>
                            @else
                                <span class="badge badge-soft-warning text-warning">
                                    <i class="fas fa-clock me-1 small"></i> Pending
                                </span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-icon btn-light" title="Edit Profile">
                                    <i class="fas fa-user-pen text-muted"></i>
                                </a>
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
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
    .badge-soft-warning { background: #fff7ed; color: #f97316; border: 1px solid #ffedd5; }
</style>
@endsection
