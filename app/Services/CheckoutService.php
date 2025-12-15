<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Bill;
use App\Models\Enrollment;
use App\Models\Coupon;
use App\Models\CouponUsage;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function processCheckout($userId, $paymentMethod, $couponCode = null, $billingInfo = [])
    {
        return DB::transaction(function () use ($userId, $paymentMethod, $couponCode, $billingInfo) {
            
            // 1. Get cart items
            $cartItems = Cart::where('user_id', $userId)->get();
            
            if ($cartItems->isEmpty()) {
                throw new \Exception('Giỏ hàng trống');
            }
            
            // 2. Calculate total
            $subtotal = $cartItems->sum('item_total');
            
            // 3. Apply coupon if exists
            $discount = 0;
            $coupon = null;
            
            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->first();
                
                if ($coupon && $coupon->canUse($userId)) {
                    $discount = $coupon->calculateDiscount($subtotal);
                }
            }
            
            $total = $subtotal - $discount;
            
            // 4. Create bill
            $bill = Bill::create([
                'id_customer' => $userId,
                'date_order' => now(),
                'total' => $total,
                'status' => 'pending',
                'payment_method' => $paymentMethod,
                'coupon_code' => $couponCode,
                'discount_amount' => $discount,
                'billing_name' => $billingInfo['name'] ?? null,
                'billing_email' => $billingInfo['email'] ?? null,
                'billing_phone' => $billingInfo['phone'] ?? null,
                'billing_address' => $billingInfo['address'] ?? null,
            ]);
            
            // 5. Create enrollments
            foreach ($cartItems as $item) {
                Enrollment::create([
                    'user_id' => $userId,
                    'course_id' => $item->course_id,
                    'bill_id' => $bill->id,
                    'enrolled_price' => $item->unit_price,
                    'status' => 'active'
                ]);
            }
            
            // 6. Record coupon usage if applied
            if ($coupon && $discount > 0) {
                CouponUsage::create([
                    'coupon_id' => $coupon->id,
                    'user_id' => $userId,
                    'bill_id' => $bill->id,
                    'discount_amount' => $discount
                ]);
                
                $coupon->incrementUsage();
            }
            
            // 7. Clear cart
            Cart::where('user_id', $userId)->delete();
            
            return [
                'success' => true,
                'bill_id' => $bill->id,
                'total' => $total,
                'enrollments_count' => $cartItems->count()
            ];
        });
    }
    
    public function getCartSummary($userId)
    {
        $cartItems = Cart::with('course')
            ->where('user_id', $userId)
            ->get();
            
        $subtotal = $cartItems->sum('item_total');
        $itemCount = $cartItems->count();
        
        return [
            'items' => $cartItems,
            'subtotal' => $subtotal,
            'item_count' => $itemCount,
            'shipping_fee' => 0,
            'total' => $subtotal
        ];
    }
    
    public function validateCoupon($code, $userId, $orderAmount)
    {
        $coupon = Coupon::where('code', $code)->first();
        
        if (!$coupon) {
            return [
                'valid' => false,
                'message' => 'Mã giảm giá không tồn tại'
            ];
        }
        
        if (!$coupon->isValid()) {
            return [
                'valid' => false,
                'message' => 'Mã giảm giá đã hết hạn hoặc không còn hiệu lực'
            ];
        }
        
        if (!$coupon->canUse($userId)) {
            return [
                'valid' => false,
                'message' => 'Bạn đã sử dụng hết số lần dùng mã này'
            ];
        }
        
        if ($orderAmount < $coupon->min_order_amount) {
            return [
                'valid' => false,
                'message' => 'Đơn hàng không đạt giá trị tối thiểu'
            ];
        }
        
        $discount = $coupon->calculateDiscount($orderAmount);
        
        return [
            'valid' => true,
            'discount' => $discount,
            'coupon' => $coupon,
            'message' => 'Mã giảm giá hợp lệ'
        ];
    }
}