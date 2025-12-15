@extends('entry')
@section('content')
<div class="container-fluid">
    <div class="row r-row">
        <!-- Left Column - Image -->
        <div class="col-lg-6 col-md-6 p-0">
            <div class="image-section">
                <img src="{{ asset('images/elements/13.jpg') }}" alt="Background Image">
                <div class="image-overlay">
                    <h1>Be a part of our Community</h1>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Register Form -->
        <div class="col-lg-6 col-md-6 p-0">
            <div class="form-section">
                <div class="login-container">
                    <div class="login-card">
                        <div class="card-header">
                            <h2 class="mb-0">Sign Up</h2>
                        </div>
                        <div class="card-body">

                            <!-- Hiển thị lỗi validation -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Hiển thị flash message -->
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <!-- Form đăng ký -->
                            <form id="loginForm" method="post" action="{{ route('register') }}">
                                @csrf

                                <!-- Email Input -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                                    </div>
                                    <div class="form-text">We'll never share your email with anyone else.</div>
                                </div>

                                <!-- Full Name -->
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <!-- Sửa name để controller nhận đúng -->
                                        <input type="text" class="form-control" id="name" name="name" placeholder="your name" required>
                                    </div>
                                    <div class="form-text">Please enter your full name.</div>
                                </div>

                                <!-- Password Input -->
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between">
                                        <label for="password" class="form-label">Password</label>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between">
                                        <label for="c_password" class="form-label">Reconfirm-Password</label>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="c_password" name="c_password" placeholder="Enter your password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword2">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Remember Me Checkbox (có thể bỏ nếu không cần) -->
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid gap-2 mb-4">
                                    <button type="submit" class="btn btn-login">
                                        Sign Up
                                    </button>
                                </div>

                                <!-- Divider & Social Buttons giữ nguyên -->
                                <div class="divider">
                                    <span>Or continue with</span>
                                </div>
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

                                <div class="footer-links">
                                    <p class="mb-0">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
