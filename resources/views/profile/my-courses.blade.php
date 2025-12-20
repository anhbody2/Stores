@extends('entry')

@section('title', 'My Courses')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user') }}">Profile</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Courses</li>
                </ol>
            </nav>
            <h1 class="display-6 fw-bold">
                <i class="fas fa-book-open text-primary me-2"></i>My Courses
            </h1>
            <p class="lead text-muted">
                All courses you've enrolled in
            </p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('courses.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-plus me-2"></i>Learn New Skills?
            </a>
        </div>
    </div>

    <!-- Sidebar and Content -->
    <div class="row">
        <div class="col-md-3">
            <!-- Sidebar Navigation -->
            <div class="card mb-4">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('user') }}" class="list-group-item list-group-item-action py-3">
                            <i class="fas fa-user me-2"></i> Profile
                        </a>
                        <a href="{{ route('my.courses') }}" class="list-group-item list-group-item-action active py-3">
                            <i class="fas fa-book me-2 py-3"></i> My Courses
                            @if($totalCourses > 0)
                            <span class="badge bg-primary float-end py-3 px-3">{{ $totalCourses }}</span>
                            @endif
                        </a>
                        <a href="{{ route('courses.index') }}" class="list-group-item list-group-item-action py-3">
                            <i class="fas fa-search me-2"></i> Browse Courses
                        </a>
                        @include('partials.pagination')
                    </div>
                </div>
            </div>
            
            <!-- Stats -->
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Learning Stats</h6>
                    <div class="text-center py-3">
                        <h1 class="text-primary">{{ $totalCourses }}</h1>
                        <p class="text-muted mb-0">Total Courses</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <!-- Courses Grid -->
            @if($totalCourses > 0)
            <div class="row">
                @foreach($courses as $course)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <!-- Course Image -->
                        @if($course->image)
                        <img src="{{ asset($course->image) }}" class="card-img-top" alt="{{ $course->name }}"
                             style="height: 160px; object-fit: cover;">
                        @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                             style="height: 160px;">
                            <i class="fas fa-graduation-cap fa-3x text-secondary"></i>
                        </div>
                        @endif
                        
                        <!-- Course Info -->
                        <div class="card-body">
                            <!-- Category -->
                            @php
                                $category = \App\Models\Category::where('category_id', $course->level)->first();
                            @endphp
                            <span class="badge bg-info mb-2">{{ $category->category_name ?? 'Unknown' }}</span>
                            
                            <!-- Title -->
                            <h5 class="card-title">{{ Str::limit($course->name, 50) }}</h5>
                            
                            <!-- Description -->
                            <p class="card-text text-muted small">
                                {{ Str::limit($course->description, 80) }}
                            </p>
                            
                            <!-- Meta -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users text-muted me-1"></i>
                                    <small>{{ number_format($course->enrolled) }}</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-star text-warning me-1"></i>
                                    <small>{{ number_format($course->rate, 1) }}</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="far fa-clock text-muted me-1"></i>
                                    <small>{{ $course->time_average }}h</small>
                                </div>
                            </div>
                            
                          
                           <div class="mb-3">
    <div class="d-flex justify-content-between align-items-center mb-1">
        <small class="text-muted">Progress</small>
        <small class="fw-bold text-primary">100%</small>
    </div>
    <div class="progress" style="height: 8px; border-radius: 4px;">
        <div class="progress-bar bg-primary" 
             style="width: 100%; border-radius: 4px;"
             role="progressbar" 
             aria-valuenow="100" 
             aria-valuemin="0" 
             aria-valuemax="100">
        </div>
    </div>
</div>
                            
                            <!-- Actions -->
                            <div class="d-grid gap-2">
                                <a href="{{ route('course.learn', $course->course_id) }}" 
   class="btn btn-primary btn-sm">
    <i class="fas fa-play-circle me-1"></i> Continue Learning
</a>
                            </div>
                        </div>
                        
                        <!-- Footer -->
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-primary fw-bold">${{ number_format($course->price, 2) }}</span>
                                <small class="text-muted">
                                    Enrolled: Recently
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <!-- Empty State -->
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-shopping-bag fa-4x text-muted"></i>
                    </div>
                    <h3 class="mb-3">No courses purchased yet</h3>
                    <p class="text-muted mb-4">Start your learning journey by enrolling in a course</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-graduation-cap me-2"></i>Browse Available Courses
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
