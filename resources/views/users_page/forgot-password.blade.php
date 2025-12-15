@extends('entry')
@section('content')
<div class="container-fluid">
    <div class="row r-row">
        <!-- Left Column - Image -->
        <div class="col-lg-6 col-md-6 p-0">
            <div class="image-section">
                <img src="{{ asset('images/elements/13.jpg') }}" alt="Background Image">
                <div class="image-overlay">
                    <h1>Reset your password</h1>
                </div>
            </div>
        </div>

        <!-- Right Column - Forgot Password Form -->
        <div class="col-lg-6 col-md-6 p-0">
            <div class="form-section">
                <div class="login-container">
                    <div class="login-card">
                        <div class="card-header">
                            <h2 class="mb-0">Forgot Password</h2>
                        </div>
                        <div class="card-body">

                            <!-- Validation Errors -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Success Message -->
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <!-- Forgot Password Form -->
                            <form method="post" action="{{ route('forgot.password.update') }}">
                                @csrf

                                <!-- Email -->
                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email"
                                               class="form-control"
                                               name="email"
                                               placeholder="name@example.com"
                                               required>
                                    </div>
                                </div>

                                <!-- New Password -->
                                <div class="mb-4">
                                    <label class="form-label">New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password"
                                               class="form-control"
                                               name="password"
                                               placeholder="Enter new password"
                                               required>
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-4">
                                    <label class="form-label">Reconfirm Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password"
                                               class="form-control"
                                               name="password_confirmation"
                                               placeholder="Confirm new password"
                                               required>
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="d-grid gap-2 mb-4">
                                    <button type="submit" class="btn btn-login">
                                        Reset Password
                                    </button>
                                </div>

                                <div class="footer-links">
                                    <p class="mb-0">
                                        Remember your password?
                                        <a href="{{ route('login') }}">Login here</a>
                                    </p>
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
