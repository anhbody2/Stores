@extends('entry')
@section('content')
<main class="container">
    <!-- Course Details Section -->
    <div class="row mb-5 course-card rounded-0">
        <!-- Course Image -->
        <div class="col-lg-6 p-0">
            <div class="course-image h-100">
                <img src="{{ $course->image }}" alt="{{ $course->name }}" class="img-fluid">
            </div>
        </div>

        <!-- Course Info -->
        <div class="col-lg-6 p-4 p-md-5">
            <h1 class="course-title mb-4">{{ $course->name }}</h1>

            <!-- Pricing -->
            <div class="d-flex align-items-center mb-4">
                <span class="price me-3">${{ number_format($course->price, 2) }}</span>
                @php
                    $original_price = $course->price * 1.5;
                @endphp
                @if($course->price < $original_price)
                <span class="original-price me-3">${{ number_format($original_price, 2) }}</span>
                <span class="discount">{{ 
                    round((($original_price - $course->price) / $original_price) * 100) 
                }}% OFF</span>
                @endif
            </div>

            <!-- Course Meta -->
            <div class="d-flex flex-wrap gap-4 mb-4 pb-3 border-bottom">
                <div class="meta-item">
                    <i class="far fa-clock"></i>
                    <span>Average Time: <strong>{{ $course->time_average }} hours</strong></span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-user-graduate"></i>
                    <span>Tutor: <strong>{{ $course->tutors ?? 'Unknown' }}</strong></span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-users"></i>
                    <span>Enrolled: <span class="enroll-count">{{ number_format($course->enrolled) }} students</span></span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-layer-group"></i>
                    <span>Object: <strong>{{ $category_name }}</strong></span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-signal"></i>
                    <span>Difficulty: <strong>{{ $difficulty_name }}</strong></span>
                </div>
            </div>

            <!-- Course Description -->
            <p class="course-description mb-4">
                {{ $course->description ?? 'No description available.' }}
            </p>

            <!-- Rating -->
            <div class="d-flex align-items-center mb-4">
                <div class="stars">
                    @php
                        $rate = $course->rate ?? 0;
                    @endphp
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($rate))
                            <i class="fas fa-star text-warning"></i>
                        @elseif($i == ceil($rate) && $rate - floor($rate) >= 0.5)
                            <i class="fas fa-star-half-alt text-warning"></i>
                        @else
                            <i class="far fa-star text-warning"></i>
                        @endif
                    @endfor
                </div>
                <span class="ms-2">{{ number_format($rate, 1) }}/5.0</span>
                <span class="ms-3 text-muted">({{ number_format($course->enrolled) }} students enrolled)</span>
            </div>

            <!-- Tutor Info -->
            @if($course->tutors)
            <div class="tutor-info d-flex align-items-center mb-4">
                <div class="tutor-avatar me-3">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80"
                        alt="{{ $course->tutors }}">
                </div>
                <div class="tutor-details">
                    <h3 class="h5 mb-1">{{ $course->tutors }}</h3>
                    <p class="text-muted mb-0">Instructor</p>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="row g-3 course-actions">
                <div class="col-md-6">
                    <button class="btn btn-enroll rounded-0" onclick="enrollCourse({{ $course -> course_id }})">
                        <i class="fas fa-shopping-cart me-2"></i> Enroll Now
                    </button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-wishlist rounded-0" onclick="addToWishlist({{ $course -> course_id }})">
                        <i class="far fa-heart me-2"></i> Add to Wishlist
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- What You'll Learn Section -->
    <div class="what-you-learn mb-5">
        <h2 class="section-title mb-4">What You'll Learn</h2>
        <div class="row">
            <div class="col-md-6">
                <ul class="list-unstyled learning-list">
                    <li><i class="fas fa-check-circle me-2"></i> Master the core concepts of {{ $course->name }}</li>
                    <li><i class="fas fa-check-circle me-2"></i> Build practical projects with step-by-step guidance</li>
                    <li><i class="fas fa-check-circle me-2"></i> Gain hands-on experience with real-world examples</li>
                    <li><i class="fas fa-check-circle me-2"></i> Develop skills that are in high demand</li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-unstyled learning-list">
                    <li><i class="fas fa-check-circle me-2"></i> Learn best practices and industry standards</li>
                    <li><i class="fas fa-check-circle me-2"></i> Get lifetime access to course materials</li>
                    <li><i class="fas fa-check-circle me-2"></i> Join a community of {{ number_format($course->enrolled) }} students</li>
                    <li><i class="fas fa-check-circle me-2"></i> Receive a certificate upon completion</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Course Details Cards -->
    <div class="row mb-5">
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-certificate text-primary mb-3" style="font-size: 2.5rem;"></i>
                    <h5 class="card-title">Certificate of Completion</h5>
                    <p class="card-text">Earn a certificate upon finishing the course to showcase your skills.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-laptop-code text-primary mb-3" style="font-size: 2.5rem;"></i>
                    <h5 class="card-title">Course Level</h5>
                    <p class="card-text">{{ $category_name }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-clock text-primary mb-3" style="font-size: 2.5rem;"></i>
                    <h5 class="card-title">Course Duration</h5>
                    <p class="card-text">{{ $course->time_average }} hours of content</p>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function enrollCourse(courseId) {
    if(confirm('Are you sure you want to enroll in this course?')) {
        window.location.href = `/enroll/${courseId}`;
    }
}

function addToWishlist(courseId) {
    alert('Course added to wishlist!');
}
</script>
@endsection