<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán thành công</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container py-5">
        <div class="text-center">
            <div class="mb-4">
                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
            </div>
            
            <h1 class="mb-3">Thanh toán thành công!</h1>
            <p class="lead mb-4">Cảm ơn bạn đã đăng ký khóa học.</p>
            
            <!-- Thông báo tự động chuyển hướng -->
            <div class="alert alert-info mb-4">
                <i class="fas fa-clock me-2"></i>
                Tự động chuyển về trang khóa học sau <span id="countdown">5</span> giây...
            </div>
            
            @if(isset($latestCourse) && $latestCourse)
            <div class="card mx-auto mb-4" style="max-width: 500px;">
                <div class="card-body">
                    <h5 class="card-title">Khóa học vừa đăng ký</h5>
                    <div class="d-flex align-items-center mb-3">
                        @if($latestCourse->image)
                        <img src="{{ asset($latestCourse->image) }}" alt="{{ $latestCourse->name }}" 
                             class="rounded me-3" style="width: 80px; height: 60px; object-fit: cover;">
                        @endif
                        <div>
                            <h6 class="mb-1">{{ $latestCourse->name }}</h6>
                            <p class="text-muted mb-1">{{ Str::limit($latestCourse->description, 80) }}</p>
                        </div>
                    </div>
                    <p><strong>Giá:</strong> {{ number_format($latestCourse->price) }} đ</p>
                    <p><strong>Thời gian đăng ký:</strong> {{ now()->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            @endif
            
            @if(isset($enrolledCourses) && $enrolledCourses->count() > 0)
            <div class="mb-4">
                <h4>Bạn đã đăng ký {{ $enrolledCount ?? $enrolledCourses->count() }} khóa học</h4>
                <div class="list-group mx-auto" style="max-width: 600px;">
                    @foreach($enrolledCourses as $course)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                @if($course->image)
                                <img src="{{ asset($course->image) }}" alt="{{ $course->name }}" 
                                     class="rounded me-3" style="width: 60px; height: 45px; object-fit: cover;">
                                @endif
                                <div>
                                    <h6 class="mb-1">{{ $course->name }}</h6>
                                    <small class="text-muted">
                                        {{ Str::limit($course->description, 50) }}
                                    </small>
                                </div>
                            </div>
                            <span class="badge bg-primary rounded-pill">
                                {{ number_format($course->price) }} đ
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('my.courses') }}" class="btn btn-primary">
                    <i class="fas fa-book me-2"></i>Xem khóa học của tôi
                </a>
                <a href="{{ route('courses.index') }}" class="btn btn-outline-primary" id="courses-link">
                    <i class="fas fa-graduation-cap me-2"></i>Tiếp tục học tập
                </a>
                <a href="{{ route('profile') }}" class="btn btn-success">
                    <i class="fas fa-user me-2"></i>Về trang cá nhân
                </a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Tự động chuyển hướng sau 5 giây
    let seconds = 5;
    const countdownElement = document.getElementById('countdown');
    const coursesLink = document.getElementById('courses-link');
    
    function updateCountdown() {
        countdownElement.textContent = seconds;
        seconds--;
        
        if (seconds < 0) {
            // Chuyển hướng đến trang courses
            window.location.href = coursesLink.href;
        } else {
            setTimeout(updateCountdown, 1000);
        }
    }
    
    // Bắt đầu đếm ngược
    setTimeout(updateCountdown, 1000);
    
    // Tùy chọn: Người dùng có thể bấm để chuyển ngay
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function() {
            // Khi người dùng bấm bất kỳ nút nào, dừng đếm ngược
            seconds = -1;
        });
    });
    </script>
</body>
</html>