@extends('entry')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Left Column - Image -->
            <div class="col-lg-6 col-md-6 p-0">
                <div class="image-section">
                    <!-- Replace with your actual image -->
                    <img src="{{ asset('images/elements/13.jpg') }}" alt="Background Image">
                    <div class="image-overlay">
                        <h1>Be a part of our Community</h1>
                        
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Login Form -->
            <div class="col-lg-6 col-md-6 p-0">
                <div class="form-section">
                    <div class="login-container">
                        <!-- Login Card -->
                        <div class="login-card">
                            <div class="card-header">
                                <h2 class="mb-0">Welcome back! Please sign in to continue</h2>
                            </div>
                            
                            <div class="card-body">
                                <!-- Login Form -->
                                <form id="loginForm" method="post" action="#">
                                    <!-- Email Input -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                                        </div>
                                        <div class="form-text">We'll never share your email with anyone else.</div>
                                    </div>
                                    
                                    <!-- Password Input -->
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between">
                                            <label for="password" class="form-label">Password</label>
                                            <a href="#" class="text-decoration-none small" style="color: var(--primary-color);">Forgot Password?</a>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Remember Me Checkbox -->
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                    
                                    <!-- Submit Button -->
                                    <div class="d-grid gap-2 mb-4">
                                        <button type="submit" class="btn btn-login">
                                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                        </button>
                                    </div>
                                    
                                    <!-- Divider -->
                                    <div class="divider">
                                        <span>Or continue with</span>
                                    </div>
                                    
                                    <!-- Social Login Buttons -->
                                    <div class="row g-2 mb-4">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-google btn-social w-100">
                                                <i class="fab fa-google me-2"></i><span>Google</span>
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button type="button" class="btn btn-facebook btn-social w-100">
                                                <i class="fab fa-facebook-f me-2"></i><span>Facebook</span>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Registration Link -->
                                    <div class="footer-links">
                                        <p class="mb-0">Don't have an account? <a href="/register">Sign up here</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    

@endsection
