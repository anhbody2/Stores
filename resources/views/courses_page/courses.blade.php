@extends('entry')
@push('styles')
    @vite('resources/css/courses/courses.css')
@endpush
@section('content')
<div class="container">

    <!-- New Courses Section -->
    <div class="mb-5">
        <h2 class="section-title">New & Trending Courses</h2>
        <p class="text-muted mb-4">Check out our latest course additions that are trending now.</p>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="new-courses-container">
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section mb-5">
        <div class="row g-3 bolder">

            <div class="col-md-6">
                <label for="categoryFilter" class="form-label">Filter by Category</label>
                <select class="form-select" id="categoryFilter">
                    <option value="all">--- All Categories ---</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="difficultyFilter" class="form-label">Filter by Difficulty</label>
                <select class="form-select" id="difficultyFilter">
                    <option value="all">--- All Levels ---</option>
                    @foreach($difficulties as $difficulty)
                    <option value="{{ $difficulty->id }}">{{ $difficulty->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-8">
                <label for="searchInput" class="form-label">Search Courses</label>
                <input type="text" class="form-control" id="searchInput"
                    placeholder="Search by course title, instructor, or keyword">
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-outline-primary w-100" id="resetFilters">Reset Filters</button>
            </div>

        </div>
    </div>

    <!-- Main Courses Grid -->
    <div class="mb-5">
        <h2 class="section-title">All Courses</h2>
        <p class="text-muted mb-4">Browse our complete course catalog.</p>

        <div id="course-container" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

        </div>

        <!-- Empty State -->
        <div id="empty-state" class="empty-state d-none">
            <i class="bi bi-search display-1 text-muted mb-3"></i>
            <h3>No courses found</h3>
            <p class="text-muted">Try adjusting your search or filter to find what you're looking for.</p>
            <button class="btn btn-primary mt-2" id="resetEmpty">Reset All Filters</button>
        </div>
    </div>

    <!-- Browse by Category -->
    <div class="mb-5">
        <h2 class="section-title">Browse by Category</h2>
        <p class="text-muted mb-4">Explore courses organized by subject area.</p>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($categories as $category)
            <div class="col">
                <div class="card category-card h-100">
                    <div class="card-body d-flex flex-column">

                        <div class="text-center mb-3">
                            <i class="{{ $category->icon }} category-icon"></i>
                        </div>

                        <h4 class="card-title text-center">{{ $category->category_name }}</h4>
                        <p class="card-text text-center flex-grow-1">{{ $category->description }}</p>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="small">Courses {{ $category->courses_count }}</span>
                                <span class="small">{{ $category->percentage }}%</span>
                            </div>

                            <div class="progress category-progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $category->percentage }}%; background-color: {{ $category->color }};"
                                    aria-valuenow="{{ $category->percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <p class="small fw-bold mb-1">Popular Courses:</p>
                            <ul class="small mb-0">
                                @foreach(getCoursesByCategory($category->category_id) as $course)
                                <li>{{ $course->name }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mt-auto">
                            <button class="btn btn-outline-primary w-100" onclick="filterByCategory({{ $category-> category_id }})">
                                Browse {{ $category->category_name }} Courses
                            </button>
                        </div>


                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>

</div>

<script>
    window.courses = @json($coursesJson);
</script>

@endsection