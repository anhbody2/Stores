<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    protected $table = 'coupon_usages';
    
    protected $fillable = [
        'coupon_id',
        'user_id',
        'bill_id',
        'discount_amount'
    ];
    
    protected $casts = [
        'discount_amount' => 'decimal:2'
    ];
    
    // Relationships
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
    
    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }
    
    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }
}