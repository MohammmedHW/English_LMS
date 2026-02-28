@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="fade-in">
    <!-- Welcome Header -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-8">
            <h1 class="display-6 mb-2">Hello, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h1>
            <p class="text-muted lead">Here's a summary of your English Learning platform today.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <div class="bg-white px-4 py-2 rounded-4 border d-inline-flex align-items-center shadow-sm">
                <i class="fas fa-calendar-day text-primary me-3"></i>
                <div class="text-start">
                    <div class="small text-muted fw-semibold">Current Date</div>
                    <div class="fw-bold small">{{ date('F d, Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overview Stats Bento Grid -->
    <div class="row g-4">
        <!-- Students Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card p-4 border-0 shadow-sm overflow-hidden h-100">
                <div class="d-flex align-items-center mb-4">
                    <div class="rounded-4 d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(79, 70, 229, 0.1); color: var(--primary);">
                        <i class="fas fa-user-graduate fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-bold text-uppercase tracking-wider">Total Students</div>
                        <div class="h3 fw-bold mb-0">{{ number_format($totalStudents) }}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-auto">
                    <span class="badge badge-soft-primary me-2">
                        <i class="fas fa-trend-up me-1"></i> Active
                    </span>
                    <span class="small text-muted">Students registered</span>
                </div>
            </div>
        </div>


        <!-- Subscriptions Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card p-4 border-0 shadow-sm overflow-hidden h-100">
                <div class="d-flex align-items-center mb-4">
                    <div class="rounded-4 d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(239, 68, 68, 0.1); color: var(--danger);">
                        <i class="fas fa-certificate fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-bold text-uppercase tracking-wider">Active Users</div>
                        <div class="h3 fw-bold mb-0">{{ $activeStudents }}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-auto">
                    <span class="badge badge-soft-primary me-2" style="background: rgba(239, 68, 68, 0.1); color: var(--danger);">
                        <i class="fas fa-bolt me-1"></i> Verified
                    </span>
                    <span class="small text-muted">Email verified</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Future Section: Charts & Recent Activities -->
    <div class="row g-4 mt-2">
        <div class="col-lg-8">
            <div class="card p-4 border-0 shadow-sm h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">Quick Access</h5>
                    <a href="#" class="btn btn-sm btn-light border px-3 rounded-3 fw-semibold small">View All</a>
                </div>
                <div class="row g-3">
                        <a href="{{ route('students.create') }}" class="text-decoration-none bg-light d-block p-4 rounded-4 border border-dashed transition-all hover-primary h-100">
                            <i class="fas fa-user-plus text-primary fs-3 mb-2"></i>
                            <div class="small fw-bold text-dark">Enroll Student</div>
                        </a>
                    </div>
                    <div class="col-md-6 text-center">
                        <a href="{{ route('plans.index') }}" class="text-decoration-none bg-light d-block p-4 rounded-4 border border-dashed transition-all hover-primary h-100">
                            <i class="fas fa-credit-card text-success fs-3 mb-2"></i>
                            <div class="small fw-bold text-dark">View Plans</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="mb-4">Platform Stats</h5>
                    <div class="d-flex flex-column gap-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-circle text-primary me-3 small"></i>
                            <div class="flex-grow-1">
                                <div class="small text-muted fw-medium">Storage Used</div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-primary" style="width: 45%;"></div>
                                </div>
                            </div>
                            <span class="ms-3 fw-bold small">45%</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-circle text-secondary me-3 small"></i>
                            <div class="flex-grow-1">
                                <div class="small text-muted fw-medium">Completion Rate</div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-secondary" style="width: 82%;"></div>
                                </div>
                            </div>
                            <span class="ms-3 fw-bold small">82%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-primary:hover {
        background: var(--primary-soft) !important;
        border-color: var(--primary) !important;
        transform: scale(1.02);
    }
    .transition-all {
        transition: all 0.2s ease;
    }
    .tracking-wider {
        letter-spacing: 0.05em;
    }
</style>
@endsection
