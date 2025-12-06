<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showSupperProVIP()
    {
        $product = [
            'id' => 1,
            'name' => 'Supper Pro VIP',
            'slug' => 'supper-pro-vip',
            'category' => 'Các khóa học khác',
            'brand' => 'Supper Tech',
            'price' => 8999000,
            'original_price' => 12500000,
            'discount_percent' => 28,
            'rating' => 4.5,
            'review_count' => 128,
            'in_stock' => true,
            'stock_quantity' => 50,
            'sku' => 'SPVIP-2024-GOLD',
            'tags' => ['Thông minh', 'Cao cấp', 'VIP', 'Công nghệ AI'],
            
            'features' => [
                'Hơn 10.000+ học viên đã áp dụng và thành công',
                'Biến kiến thức thành tiền – không lan man lý thuyết',
                'Lộ trình từ số 0 đến dòng tiền bền vững',
                'Tập trung vào hành động – loại bỏ 90% kiến thức thừa',
                'Áp dụng ngay – có kết quả ngay từ tuần đầu tiên'
            ],
            
            'specifications' => [
                'Mục tiêu khoá học' => 'Xây dựng tư duy giàu có, phát triển kỹ năng kinh doanh thực chiến',
'Nội dung chính' => 'Tư duy tài chính, quản trị tiền, kinh doanh online, đầu tư cơ bản',
'Thời lượng' => '30 giờ học, 12 module chi tiết',
'Hình thức học' => 'Online 100%, xem lại trọn đời',
'Giảng viên' => 'Chuyên gia kinh doanh & tài chính với 10 năm kinh nghiệm',
'Hỗ trợ' => 'Cộng đồng học viên, mentor hỗ trợ 1-1',
'Tài nguyên' => 'Tài liệu PDF, video HD, bài tập thực hành',
'Ứng dụng thực tế' => 'Áp dụng vào kinh doanh online, đầu tư cá nhân, phát triển thu nhập thụ động',
'Yêu cầu' => 'Không cần kiến thức trước, phù hợp cho người mới',
'Chứng nhận' => 'Certificate hoàn thành khoá học',
'Cam kết' => 'Hoàn tiền 100% nếu không hài lòng trong 7 ngày'

            ],
            
            'images' => [
                'main' => asset('images/products/anh1.webp'),
                'thumbnails' => [
                    asset('images/products/anh1.1.webp'), 
                    asset('images/products/anh1.2.webp'), 
                    asset('images/products/anh1.1.webp'), 
                    asset('images/products/anh1.webp')  
                ]
            ],
            
            // THÊM PHẦN VIDEO VÀO ĐÂY - QUAN TRỌNG!
            'video' => [
                'url' => asset('videos/products/video1.mp4'), // Video URL
                'title' => 'Giới thiệu Supper Pro VIP',
                'thumbnail' => asset('images/products/video-thumbnail.jpg'), // Có thể bỏ nếu không có
                'duration' => '02:15'
            ],
            
           
            
            'related_products' => [
                [
                    'id' => 2,
                    'name' => 'Supper Pro X',
                    'price' => 6999000,
                    'image' => '',
                    'rating' => 4.2
                ],
                [
                    'id' => 3,
                    'name' => 'Supper Lite',
                    'price' => 4999000,
                    'image' => '',
                    'rating' => 4.0
                ],
                [
                    'id' => 4,
                    'name' => 'Supper Max',
                    'price' => 10999000,
                    'image' => '',
                    'rating' => 4.8
                ]
            ]
        ];
        
        return view('products.detail', compact('product'));
    }
}