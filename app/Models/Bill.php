<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';
    
    protected $fillable = [
        'id_customer',
        'date_order',
        'total',
        'status',
        'payment',
        'payment_method',
        'payment_gateway',
        'transaction_id',
        'coupon_code',
        'discount_amount',
        'tax_amount',
        'shipping_fee',
        'paid_at',
        'billing_name',
        'billing_email',
        'billing_phone',
        'billing_address',
        'note'
    ];
    
    protected $casts = [
        'total' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'date_order' => 'date',
        'paid_at' => 'datetime'
    ];
    
    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }
    
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'bill_id');
    }
    
    public function couponUsages()
    {
        return $this->hasMany(CouponUsage::class, 'bill_id');
    }
    
    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
    
    public function scopeForCustomer($query, $customerId)
    {
        return $query->where('id_customer', $customerId);
    }
    
    // Methods
    public function getFinalTotalAttribute()
    {
        return $this->total - $this->discount_amount + $this->tax_amount + $this->shipping_fee;
    }
    
    public function markAsPaid($paymentData = [])
    {
        $this->status = 'paid';
        $this->paid_at = now();
        
        if (!empty($paymentData)) {
            $this->fill($paymentData);
        }
        
        return $this->save();
    }
    
    public static function createFromCart($customerId, $cartItems, $couponCode = null)
    {
        $subtotal = collect($cartItems)->sum(function($item) {
            return $item->unit_price * $item->quantity;
        });
        
        // Apply coupon if exists
        $discount = 0;
        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
            if ($coupon && $coupon->isValid()) {
                $discount = $coupon->calculateDiscount($subtotal);
            }
        }
        
        $total = $subtotal - $discount;
        
        return self::create([
            'id_customer' => $customerId,
            'date_order' => now(),
            'total' => $total,
            'status' => 'pending',
            'coupon_code' => $couponCode,
            'discount_amount' => $discount
        ]);
    }
}