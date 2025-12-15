<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký khóa học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4">
            <i class="fas fa-shopping-cart me-2"></i>Đăng ký khóa học
        </h1>
        
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        @if(session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif
        
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-book me-2"></i>Khóa học</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            @if($course->image)
                                <img src="{{ asset($course->image) }}" alt="{{ $course->name }}" 
                                     class="rounded me-3" style="width: 120px; height: 90px; object-fit: cover;">
                            @else
                                <div class="rounded bg-light d-flex align-items-center justify-content-center me-3" 
                                     style="width: 120px; height: 90px;">
                                    <i class="fas fa-graduation-cap fa-2x text-secondary"></i>
                                </div>
                            @endif
                            <div>
                                <h5 class="mb-1">{{ $course->name }}</h5>
                                <p class="text-muted mb-1">{{ Str::limit($course->description, 150) }}</p>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-info me-2">
                                        <i class="fas fa-users me-1"></i>{{ $course->enrolled }} học viên
                                    </span>
                                    <span class="badge bg-warning me-2">
                                        <i class="fas fa-star me-1"></i>{{ $course->rate }}/5
                                    </span>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-clock me-1"></i>{{ $course->time_average }} giờ
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Thông tin người đăng ký -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Thông tin người đăng ký</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Tổng thanh toán</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Giá khóa học:</td>
                                <td class="text-end">{{ number_format($course->price) }} đ</td>
                            </tr>
                            <tr>
                                <td>Giảm giá:</td>
                                <td class="text-end text-success">0 đ</td>
                            </tr>
                            <tr class="table-active">
                                <th>Tổng cộng:</th>
                                <th class="text-end">{{ number_format($total) }} đ</th>
                            </tr>
                        </table>
                        
                        <form action="{{ route('course.checkout.process', $course->course_id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="payment_method" class="form-label">
                                    <i class="fas fa-credit-card me-1"></i>Phương thức thanh toán
                                </label>
                                <select name="payment_method" id="payment_method" class="form-select" required>
                                    <option value="direct">💳 Thanh toán trực tiếp</option>
                                    <option value="bank_transfer">🏦 Chuyển khoản ngân hàng</option>
                                    <option value="momo">📱 Ví MoMo</option>
                                </select>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="agree_terms" required>
                                <label class="form-check-label" for="agree_terms">
                                    Tôi đồng ý với <a href="#" target="_blank">điều khoản dịch vụ</a>
                                </label>
                            </div>
                            
                            <button type="submit" class="btn btn-success btn-lg w-100 mb-3">
                                <i class="fas fa-lock me-2"></i>Xác nhận đăng ký - {{ number_format($total) }} đ
                            </button>
                        </form>
                        
                        <a href="{{ route('course.show', $course->course_id) }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại khóa học
                        </a>
                        
                        <div class="mt-3 p-3 bg-light rounded">
                            <p class="mb-1 small">
                                <i class="fas fa-shield-alt text-primary me-1"></i>
                                Thanh toán an toàn
                            </p>
                            <p class="mb-1 small">
                                <i class="fas fa-clock text-primary me-1"></i>
                                Truy cập ngay sau khi thanh toán
                            </p>
                            <p class="mb-0 small">
                                <i class="fas fa-headset text-primary me-1"></i>
                                Hỗ trợ 24/7
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('payment_method').addEventListener('change', function() {
            const selected = this.value;
            const confirmBtn = document.querySelector('button[type="submit"]');
            
            if (selected === 'direct') {
                confirmBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Xác nhận đăng ký - {{ number_format($total) }} đ';
            } else if (selected === 'bank_transfer') {
                confirmBtn.innerHTML = '<i class="fas fa-university me-2"></i>Chuyển khoản - {{ number_format($total) }} đ';
            } else if (selected === 'momo') {
                confirmBtn.innerHTML = '<i class="fas fa-mobile-alt me-2"></i>Thanh toán MoMo - {{ number_format($total) }} đ';
            }
        });
    </script>
</body>
</html>