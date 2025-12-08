@extends('entry')
@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="header-section">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold">Course Catalog</h1>
                <p class="lead">Browse our comprehensive collection of courses to advance your skills and career.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <button class="badge bg-light text-dark fs-6 p-2"> <a id="add-course-link" href="/courses/create">Add Course</a></button>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="categoryFilter" class="form-label">Filter by Category</label>
                <select class="form-select" id="categoryFilter">
                    @foreach($categories as $category)
                    <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="difficultyFilter" class="form-label">Filter by Difficulty</label>
                <select class="form-select" id="difficultyFilter">
                    <option value="all">All Levels</option>
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
            </div>
            <div class="col-md-8">
                <label for="searchInput" class="form-label">Search Courses</label>
                <input type="text" class="form-control" id="searchInput" placeholder="Search by course title, instructor, or keyword">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-outline-primary w-100" id="resetFilters">Reset Filters</button>
            </div>
        </div>
    </div>

    <!-- Course Grid -->
    <div id="course-container" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($courses as $course)
        <div class="col">
            <div class="card course-card h-100">
                <img src="{{ $course-> image}}" class="card-img-top course-img" alt="{{ $course->title }}">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-secondary course-category">{{ $categories->firstWhere('category_id', $course->level)->category_name ?? 'Unknown' }}
                        </span>
                        <span class="badge  course-difficulty"></span>
                    </div>
                    <h5 class="card-title">{{ $course-> name }}</h5>
                    <p class="card-text flex-grow-1">{{ $course->description }}</p>
                    <p class="card-text"><i class="fa-solid fa-circle-user"></i> {{ $course->tutors }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div>
                            <span class="text-warning">{!! star_rating($course->rate) !!}</span>
                            <span class="text-muted ms-1">{{ $course->rate }}</span>
                        </div>
                        <span class="course-duration"><i class="bi bi-clock"></i> {{ $course->duration }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="course-price">${{ $course->price }}</div>
                        <div class="text-muted small"><i class="fa-solid fa-dove"></i> {{ number_format($course->enrolled) }} students</div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <button class="btn btn-sm btn-outline-primary me-md-2" onclick="">View Details</button>
                        <button class="btn btn-sm btn-primary">Enroll Now</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State (hidden by default) -->
    <div id="empty-state" class="empty-state d-none">
        <i class="bi bi-search display-1 text-muted mb-3"></i>
        <h3>No courses found</h3>
        <p class="text-muted">Try adjusting your search or filter to find what you're looking for.</p>
        <button class="btn btn-primary mt-2" id="resetEmpty">Reset All Filters</button>
    </div>

    <!-- Footer -->
    <div class="footer text-center">
        <p>Course Catalog &copy; 2023. All rights reserved.</p>
        <p class="small">This page displays simulated course data. In a real application, this would be populated from your database.</p>
    </div>
</div>
@endsection