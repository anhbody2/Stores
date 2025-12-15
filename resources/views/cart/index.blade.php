# Tạo lại file view với cú pháp đúng
@"
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - {{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <div class="container mt-4">
        <h1>🛒 Giỏ hàng của bạn</h1>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(isset($cartItems) && $cartItems->isEmpty())
            <div class="alert alert-info">
                Giỏ hàng của bạn đang trống.
            </div>
            <a href="/" class="btn btn-primary">Tiếp tục mua sắm</a>
        @elseif(isset($cartItems))
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Khóa học</th>
                            <th>Giá</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $item->course->title ?? 'N/A' }}</strong>
                                <p class="text-muted mb-0 small">
                                    {{ $item->course->description ?? '' }}
                                </p>
                            </td>
                            <td class="text-end">
                                {{ number_format($item->course->price ?? 0) }} đ
                            </td>
                            <td>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Xóa khỏi giỏ hàng?')">
                                        Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="table-active">
                            <td colspan="2" class="text-end"><strong>Tổng cộng:</strong></td>
                            <td class="text-end"><strong>{{ number_format($total) }} đ</strong></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between">
                <div>
                    <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning" 
                                onclick="return confirm('Xóa toàn bộ giỏ hàng?')">
                            Xóa tất cả
                        </button>
                    </form>
                    <a href="/" class="btn btn-secondary">Tiếp tục mua sắm</a>
                </div>
                <div>
                    <a href="/checkout" class="btn btn-success btn-lg">
                        Thanh toán
                    </a>
                </div>
            </div>
        @else
            <div class="alert alert-warning">
                Không thể tải giỏ hàng. Vui lòng đăng nhập.
            </div>
        @endif
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php 
 ?>
</html>
"@ | Out-File -FilePath "resources\views\cart\index.blade.php" -Encoding UTF8 -Force