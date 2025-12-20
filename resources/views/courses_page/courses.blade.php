@extends('entry')
@push('styles')
@vite('resources/css/courses/courses.css')
@endpush
@section('content')
<div class="container">
    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="{{ asset('images/img/carousel-1.jpg') }}" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                    style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-white text-uppercase mb-3 animated slideInDown">Best Online Courses
                                </h5>
                                <h1 class="display-3 text-white animated slideInDown">The Best Online Learning Platform
                                </h1>
                                <p class="fs-5 text-white mb-4 pb-2">Vero elitr justo clita lorem. Ipsum dolor at sed
                                    stet sit diam no. Kasd rebum ipsum et diam justo clita et kasd rebum sea sanctus
                                    eirmod elitr.</p>
                                <a href="/about" class="btn btn-primary py-md-3  px-md-5 me-3 animated slideInLeft">Read
                                    More</a>
                                <a href="/courses" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Join Now</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel-item position-relative ">
                <img class="img-fluid" src="{{ asset('images/img/carousel-2.jpg') }}" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                    style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-white text-uppercase mb-3 animated slideInDown">Best Online Courses
                                </h5>
                                <h1 class="display-3 text-white animated slideInDown">Get Educated Online From Your Home
                                </h1>
                                <p class="fs-5 text-white mb-4 pb-2">Vero elitr justo clita lorem. Ipsum dolor at sed
                                    stet sit diam no. Kasd rebum ipsum et diam justo clita et kasd rebum sea sanctus
                                    eirmod elitr.</p>
                                <a href="/about" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read
                                    More</a>
                                <a href="/courses" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Join Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @foreach($recentCourses as $course)
            <div class="owl-carousel-item position-relative banner ">
                <img class="img-fluid" src="{{ $course->image }}" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                    style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-white text-uppercase mb-3 animated slideInDown">Best Online Courses
                                </h5>
                                <h1 class="display-3 text-white animated slideInDown">{{ $course->name }}
                                </h1>
                                <p class="fs-5 text-white mb-4 pb-2">
                                    {{ Str::limit($course->description, 120) }}
                                </p>
                                <a href="{{ url('/course/' . $course->course_id) }}" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read
                                    More</a>
                                <a href="{{ url('/course/' . $course->course_id) }}" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Join Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Carousel End -->

    <!-- New Courses Section -->
    <div class="mb-5">
        <h2 class="section-title">New & Trending Courses</h2>
        <p class="text-muted mb-4">
            Check out our latest course additions that are trending now.
        </p>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" id="new-courses-container">
            @foreach ($recentCourses as $course)
            <div class="col d-flex flex-column ">
                <a href="{{ url('/course/' . $course->course_id) }}"
                    class="text-decoration-none text-dark">
                    <div class="card course-card h-100 ">
                        <img src="{{ $course->image }}"
                            class="card-img-top course-img"
                            alt="{{ $course->name }}">

                        <div class="card-body d-flex flex-column">

                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-primary course-category">
                                    {{
                                    $categories->firstWhere('category_id', $course->level)->category_name ?? 'Unknown'
                                    }}
                                </span>

                                <span class="badge course-difficulty">
                                    {{
                                    $difficulties->firstWhere('id', $course->difficulty)->name ?? 'Unknown'
                                    }}
                                </span>
                            </div>

                            <h5 class="card-title">
                                {{ $course->name }}
                            </h5>

                            <p class="card-text flex-grow-1">
                                {{ Str::limit($course->description, 120) }}
                            </p>

                            <p class="card-text">
                                <i class="fa-solid fa-circle-user"></i>
                                {{ $course->tutors }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div>
                                    <span class="text-warning">
                                        {!! star_rating($course->rate) !!}
                                    </span>
                                    <span class="text-muted ms-1">
                                        {{ number_format($course->rate, 1) }}
                                    </span>
                                </div>

                                <span class="course-duration">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $course->time_average }}h
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="course-price">
                                    ${{ number_format($course->price, 2) }}
                                </div>

                                <div class="text-muted small">
                                    <i class="fa-solid fa-dove"></i>
                                    {{ number_format($course->enrolled) }} students
                                </div>
                            </div>

                        </div>
                </a>
            </div>
        </div>
        @endforeach
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

                            <div class="progress category-progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $category->percentage }}%; background-color: {{$category->color}};"
                                    aria-valuenow="{{ $category->percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
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

<div class="container-xxl py-5 wow fadeInUp mb-5" data-wow-delay="0.1s">
    <div class="container">
        <div class="text-center">
            <h6 class="section-title bg-white text-center text-primary px-3">Testimonial</h6>
            <h1 class="mb-5">Our Students Say!</h1>
        </div>
        <div class="owl-carousel testimonial-carousel position-relative">
            @foreach($comments as $comment)
            <div class="testimonial-item text-center">
                <img class="border rounded-circle p-2 mx-auto mb-3" src="{{
                                    $users->firstWhere('id', $comment->user_id)->image ?? 'https://i.pinimg.com/736x/f5/1d/e1/f51de1d579f664e565b167acae3c6977.jpg'
                                    }}"
                    style="width: 80px; height: 80px;">
                <h5 class="mb-0">{{
                                    $users->firstWhere('id', $comment->user_id)->name ?? 'Unknown'
                                    }}</h5>
                <p>Profession</p>
                <div class="testimonial-text bg-light text-center p-4">
                    <p class="mb-0">{{$comment -> comment}}</p>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

</div>

<script>
    window.courses = @json($coursesJson);
</script>

@endsection