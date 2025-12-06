<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product['name'] }} - Chi Tiết Sản Phẩm</title>
    
    <!-- External CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/product-detail.css') }}" rel="stylesheet">
    
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="product-header text-center">
            <span class="product-badge">SẢN PHẨM CAO CẤP</span>
            <h1 class="mb-0">{{ $product['name'] }}</h1>
        </div>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Sản phẩm</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">{{ $product['category'] }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product['name'] }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Product Gallery -->
            <div class="col-lg-6">
                <div class="product-gallery">
                    <div class="main-image" id="mainImageContainer">
                        <img src="{{ $product['images']['main'] }}" 
                             alt="{{ $product['name'] }}" 
                             id="mainImage"
                             data-zoom="{{ $product['images']['main'] }}">
                    </div>
                    
                    <div class="thumbnail-images">
                        @foreach($product['images']['thumbnails'] as $index => $thumbnail)
                            <div class="thumbnail {{ $index == 0 ? 'active' : '' }}" 
                                 data-image="{{ $thumbnail }}"
                                 data-zoom="{{ str_replace('w=200', 'w=1200', $thumbnail) }}">
                                <img src="{{ $thumbnail }}" alt="{{ $product['name'] }} - ảnh {{ $index + 1 }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-info">
                    <h1 class="product-title">{{ $product['name'] }}</h1>
                    
                    <div class="product-meta">
                        <div class="product-rating">
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product['rating']))
                                        <i class="fas fa-star"></i>
                                    @elseif($i - 0.5 <= $product['rating'])
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <div class="rating-count">
                                {{ $product['rating'] }}/5 ({{ $product['review_count'] }} đánh giá)
                            </div>
                        </div>
                        
                        <div class="product-sku">
                            SKU: {{ $product['sku'] }}
                        </div>
                        
                        <div class="stock-status {{ $product['in_stock'] ? 'in-stock' : 'out-of-stock' }}">
                            <i class="fas {{ $product['in_stock'] ? 'fa-check-circle' : 'fa-times-circle' }} me-2"></i>
                            {{ $product['in_stock'] ? 'Còn hàng (' . $product['stock_quantity'] . ' sản phẩm)' : 'Hết hàng' }}
                        </div>
                    </div>
                    
                    <div class="product-price">
                        <span class="current-price">{{ number_format($product['price'], 0, ',', '.') }} ₫</span>
                        <span class="original-price">{{ number_format($product['original_price'], 0, ',', '.') }} ₫</span>
                        <span class="discount-badge">-{{ $product['discount_percent'] }}%</span>
                    </div>
                    
                    <div class="features-list">
                        <h5 class="mb-3">Đặc điểm nổi bật:</h5>
                        <ul>
                            @foreach($product['features'] as $feature)
                                <li><i class="fas fa-check-circle"></i> {{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Tags -->
                    <div class="product-tags mb-4">
                        @foreach($product['tags'] as $tag)
                            <span class="badge bg-light text-dark border me-2">{{ $tag }}</span>
                        @endforeach
                    </div>
                    
                    <div class="action-buttons">
                        <button class="btn-action btn-primary" id="addToCart">
                            <i class="fas fa-shopping-cart btn-icon"></i> Thêm vào giỏ hàng
                        </button>
                        <button class="btn-action btn-secondary" id="buyNow">
                            <i class="fas fa-bolt btn-icon"></i> Đăng ký ngay
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Specifications -->
        <div class="specifications-section">
            <h3 class="section-title">Thông số kỹ thuật</h3>
            <div class="specs-grid">
                @foreach($product['specifications'] as $key => $value)
                    <div class="spec-item">
                        <div class="spec-label">{{ $key }}:</div>
                        <div class="spec-value">{{ $value }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Video Section -->
        @if(isset($product['video']))
        <div class="video-section mt-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="section-title mb-4">
                        <i class="fas fa-play-circle text-primary me-2"></i>
                        {{ $product['video']['title'] ?? 'Video giới thiệu' }}
                    </h3>
                    
                    <div class="ratio ratio-16x9 rounded overflow-hidden">
                        <video 
                            controls 
                            @if(isset($product['video']['thumbnail']))
                                poster="{{ $product['video']['thumbnail'] }}"
                            @endif
                            class="w-100 h-100"
                            style="object-fit: contain; background-color: #000;">
                            <source src="{{ $product['video']['url'] }}" type="video/mp4">
                            Trình duyệt của bạn không hỗ trợ video.
                        </video>
                    </div>
                    
                    @if(isset($product['video']['duration']))
                        <div class="mt-3 d-flex align-items-center text-muted">
                            <i class="far fa-clock me-2"></i>
                            <span>Thời lượng: {{ $product['video']['duration'] }}</span>
                        </div>
                    @endif
                    
                    <!-- Debug thông tin video (có thể xóa sau) -->
                    <div style="display:none; font-size:12px; color:#666; margin-top:10px;">
                        Video URL: {{ $product['video']['url'] ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Related Products -->
        <div class="related-products">
            <h3 class="section-title">Sản phẩm liên quan</h3>
            <div class="row">
                @foreach($product['related_products'] as $related)
                    <div class="col-md-4 mb-4">
                        <div class="related-product-card">
                            <img src="{{ $related['image'] }}" alt="{{ $related['name'] }}" class="related-product-image">
                            <div class="related-product-info">
                                <h5 class="related-product-name">{{ $related['name'] }}</h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="related-product-price">{{ number_format($related['price'], 0, ',', '.') }} ₫</div>
                                    <div class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($related['rating']))
                                                <i class="fas fa-star fa-sm"></i>
                                            @elseif($i - 0.5 <= $related['rating'])
                                                <i class="fas fa-star-half-alt fa-sm"></i>
                                            @else
                                                <i class="far fa-star fa-sm"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <a href="#" class="btn btn-outline-primary w-100 mt-3">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="related-info mt-5">
                    <h3 class="section-title">Liên hệ : huy****@gmail.com</h3>
                    <div>
                        Giới thiệu về Vua Hàng Hiệu Việt Nam<br>
                        Quy chế hoạt động<br>
                        Hợp tác với Vua Hàng Hiệu<br>
                        Chương trình Affiliate - Cộng tác viên<br>
                        Tuyển dụng<br>
                        Liên hệ <br>
                        Hướng dẫn cách tra cứu mã đơn hàng mua trên Vua Hàng Hiệu<br>
                        Sản phẩm cần đổi hết hàng?<br>
                        Nếu không có hóa đơn mua hàng tôi có thể trả lại sản phẩm không?<br>
                        Đơn hàng nhận được bị thiếu so với đơn hàng đã đặt<br>
                        Sản phẩm nhận được không giống với hình ảnh trên website?<br>
                        Vì sao tôi nhận được thông báo đơn hàng đã hủy do hết hàng?<br>
                        Nếu gặp vấn đề trong quá trình sử dụng sản phẩm, tôi cần liên hệ với ai?
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="zoomModal" class="zoom-modal">
        <span class="close-zoom">&times;</span>
        <img class="zoom-modal-content" id="zoomedImage">
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>