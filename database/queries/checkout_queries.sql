-- ============================================
-- CÁC QUERY QUAN TRỌNG CHO CHECKOUT & ENROLL
-- ============================================

-- 1. Lấy giỏ hàng của user với thông tin khóa học
SELECT 
    c.id as cart_id,
    cr.course_id,
    cr.name as course_name,
    cr.image,
    cr.price as original_price,
    c.unit_price,
    c.quantity,
    (c.unit_price * c.quantity) as item_total
FROM cart c
JOIN courses cr ON c.course_id = cr.course_id
WHERE c.user_id = :user_id;

-- 2. Tính tổng giỏ hàng
SELECT 
    SUM(c.unit_price * c.quantity) as subtotal,
    COUNT(*) as item_count,
    SUM(c.quantity) as total_quantity
FROM cart c
WHERE c.user_id = :user_id;

-- 3. Lấy khóa học đã ghi danh của user
SELECT 
    e.id as enrollment_id,
    cr.course_id,
    cr.name as course_name,
    cr.image,
    e.enrolled_price,
    e.status,
    e.progress,
    e.total_study_time,
    e.enrolled_at,
    e.last_accessed
FROM enrollments e
JOIN courses cr ON e.course_id = cr.course_id
WHERE e.user_id = :user_id
ORDER BY e.enrolled_at DESC;

-- 4. Lịch sử đơn hàng của customer
SELECT 
    b.id as bill_id,
    b.date_order,
    b.total,
    b.status,
    b.payment_method,
    b.coupon_code,
    b.discount_amount,
    b.final_total,
    b.paid_at,
    COUNT(e.id) as course_count
FROM bills b
LEFT JOIN enrollments e ON b.id = e.bill_id
WHERE b.id_customer = :customer_id
GROUP BY b.id
ORDER BY b.date_order DESC;

-- 5. Chi tiết đơn hàng
SELECT 
    b.*,
    c.name as customer_name,
    c.email as customer_email,
    c.phone_number,
    GROUP_CONCAT(cr.name SEPARATOR ', ') as course_names,
    COUNT(e.id) as total_courses
FROM bills b
JOIN customer c ON b.id_customer = c.id
LEFT JOIN enrollments e ON b.id = e.bill_id
LEFT JOIN courses cr ON e.course_id = cr.course_id
WHERE b.id = :bill_id
GROUP BY b.id;

-- 6. Top khóa học được mua nhiều nhất
SELECT 
    cr.course_id,
    cr.name as course_name,
    COUNT(e.id) as enrollment_count,
    SUM(e.enrolled_price) as total_revenue
FROM enrollments e
JOIN courses cr ON e.course_id = cr.course_id
WHERE e.status = 'active'
GROUP BY cr.course_id, cr.name
ORDER BY enrollment_count DESC
LIMIT 10;

-- 7. Kiểm tra coupon có hợp lệ không
SELECT 
    c.*,
    CASE 
        WHEN c.is_active = 0 THEN 'inactive'
        WHEN NOW() < c.valid_from THEN 'not_started'
        WHEN NOW() > c.valid_to THEN 'expired'
        WHEN c.usage_limit IS NOT NULL AND c.usage_count >= c.usage_limit THEN 'limit_reached'
        ELSE 'valid'
    END as validation_status
FROM coupons c
WHERE c.code = :coupon_code;

-- 8. Thống kê doanh thu theo tháng
SELECT 
    YEAR(b.date_order) as year,
    MONTH(b.date_order) as month,
    COUNT(b.id) as bill_count,
    SUM(b.total) as total_revenue,
    SUM(b.discount_amount) as total_discount
FROM bills b
WHERE b.status = 'paid'
GROUP BY YEAR(b.date_order), MONTH(b.date_order)
ORDER BY year DESC, month DESC;

-- 9. User đang học những khóa học nào
SELECT 
    u.id as user_id,
    u.name as user_name,
    e.progress,
    cr.name as course_name,
    e.enrolled_at,
    e.last_accessed
FROM enrollments e
JOIN customer u ON e.user_id = u.id
JOIN courses cr ON e.course_id = cr.course_id
WHERE e.status = 'active'
AND e.progress < 100
ORDER BY e.last_accessed DESC;

-- 10. Xóa cart cũ (hơn 30 ngày)
DELETE FROM cart 
WHERE added_at < DATE_SUB(NOW(), INTERVAL 30 DAY)
AND user_id IS NOT NULL;