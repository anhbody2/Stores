@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <!-- Sidebar Navigation -->
            <div class="card mb-4">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('user') }}" class="list-group-item list-group-item-action active">
                            <i class="fas fa-user me-2"></i> Profile
                        </a>
                        <a href="{{ route('my.courses') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-book me-2"></i> My Courses
                            @if($enrollments_count > 0)
                            <span class="badge bg-primary float-end">{{ $enrollments_count }}</span>
                            @endif
                        </a>
                        <a href="{{ route('courses.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-search me-2"></i> Browse Courses
                        </a>
                        <a href="/logout" class="list-group-item list-group-item-action text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <!-- Profile Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-4">
                            <div class="avatar-circle" style="width: 80px; height: 80px; border-radius: 50%; background: #e9ecef; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user fa-2x text-secondary"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="mb-1">{{ $user->name }}</h3>
                            <p class="text-muted mb-2">{{ $user->email }}</p>
                            <div class="d-flex gap-3">
                                <span class="badge bg-primary">
                                    <i class="fas fa-book me-1"></i> {{ $enrollments_count }} Courses
                                </span>
                                <span class="badge bg-secondary">
                                    Member since {{ $user->created_at->format('M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Courses -->
            @if($enrollments_count > 0)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recently Enrolled Courses</h5>
                    <a href="{{ route('my.courses') }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    @if($recentCourses && $recentCourses->count() > 0)
                    <div class="row">
                        @foreach($recentCourses as $course)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title">{{ Str::limit($course->name, 40) }}</h6>
                                    <p class="card-text small text-muted mb-2">
                                        {{ Str::limit($course->description, 60) }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-info">
                                            ${{ number_format($course->price) }}
                                        </span>
                                        <a href="{{ route('course.show', $course->course_id) }}" class="btn btn-sm btn-primary">
                                            Continue
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted mb-0">No recent courses</p>
                    @endif
                </div>
            </div>
            @endif

            <!-- Quick Stats -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Learning Overview</h5>
                </div>
                <div class="card-body">
                    @if($enrollments_count > 0)
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded">
                                <h3 class="text-primary">{{ $enrollments_count }}</h3>
                                <p class="mb-0 text-muted">Total Courses</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded">
                                <h3 class="text-primary">0</h3>
                                <p class="mb-0 text-muted">Completed</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded">
                                <h3 class="text-primary">{{ $enrollments_count }}</h3>
                                <p class="mb-0 text-muted">In Progress</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded">
                                <h3 class="text-primary">0</h3>
                                <p class="mb-0 text-muted">Certificates</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('my.courses') }}" class="btn btn-primary">
                            <i class="fas fa-book me-2"></i>Go to My Courses
                        </a>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                        <h4>Start Your Learning Journey</h4>
                        <p class="text-muted mb-4">You haven't enrolled in any courses yet</p>
                        <a href="{{ route('courses.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-search me-2"></i>Browse Courses
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection