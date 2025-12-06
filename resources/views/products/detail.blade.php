@extends('entry')
@section('content')
<main class="container">
    <!-- Course Details Section -->
    <div class="row mb-5 course-card rounded-0">
        <!-- Course Image -->
        <div class="col-lg-6 p-0">
            <div class="course-image h-100">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                    alt="Web Development Course" class="img-fluid">
            </div>
        </div>

        <!-- Course Info -->
        <div class="col-lg-6 p-4 p-md-5">
            <h1 class="course-title mb-4">Complete Web Development Bootcamp 2024</h1>

            <!-- Pricing -->
            <div class="d-flex align-items-center mb-4">
                <span class="price me-3">$89.99</span>
                <span class="original-price me-3">$199.99</span>
                <span class="discount">55% OFF</span>
            </div>

            <!-- Course Meta -->
            <div class="d-flex flex-wrap gap-4 mb-4 pb-3 border-bottom">
                <div class="meta-item">
                    <i class="far fa-clock"></i>
                    <span>Average Time: <strong>42 hours</strong></span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-user-graduate"></i>
                    <span>Tutor: <strong>Alex Johnson</strong></span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-users"></i>
                    <span>Enrolled: <span class="enroll-count">12,847 students</span></span>
                </div>
            </div>

            <!-- Course Description -->
            <p class="course-description mb-4">
                Master web development with HTML5, CSS3, JavaScript, React, Node.js, and more! This comprehensive
                course will take you from beginner to advanced level. Build real-world projects and create a
                portfolio that will impress employers.
            </p>

            <!-- Tutor Info -->
            <div class="tutor-info d-flex align-items-center mb-4">
                <div class="tutor-avatar me-3">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80"
                        alt="Alex Johnson">
                </div>
                <div class="tutor-details">
                    <h3 class="h5 mb-1">Alex Johnson</h3>
                    <p class="text-muted mb-0">Senior Full-Stack Developer & Instructor</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row g-3 course-actions">
                <div class="col-md-6">
                    <button class="btn btn-enroll rounded-0">
                        <i class="fas fa-shopping-cart me-2"></i> Enroll Now
                    </button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-wishlist rounded-0">
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
                    <li><i class="fas fa-check-circle me-2"></i> Build responsive websites with HTML5 and CSS3</li>
                    <li><i class="fas fa-check-circle me-2"></i> Master JavaScript fundamentals and advanced
                        concepts</li>
                    <li><i class="fas fa-check-circle me-2"></i> Create dynamic web applications with React</li>
                    <li><i class="fas fa-check-circle me-2"></i> Develop server-side applications with Node.js and
                        Express</li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-unstyled learning-list">
                    <li><i class="fas fa-check-circle me-2"></i> Work with databases (MongoDB and SQL)</li>
                    <li><i class="fas fa-check-circle me-2"></i> Implement user authentication and authorization
                    </li>
                    <li><i class="fas fa-check-circle me-2"></i> Deploy applications to cloud platforms</li>
                    <li><i class="fas fa-check-circle me-2"></i> Build a professional portfolio with 10+ projects
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Additional Course Info (Optional) -->
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
                    <h5 class="card-title">Hands-On Projects</h5>
                    <p class="card-text">Build 10+ real-world projects to apply your learning and build a portfolio.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-headset text-primary mb-3" style="font-size: 2.5rem;"></i>
                    <h5 class="card-title">Lifetime Access</h5>
                    <p class="card-text">Get lifetime access to course materials, including future updates.</p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection