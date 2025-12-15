<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $table = 'coupons';
    
    protected $fillable = [
        'code',
        'name',
        'description',
        'discount_type',
        'discount_value',
        'max_discount_amount',
        'min_order_amount',
        'valid_from',
        'valid_to',
        'usage_limit',
        'usage_count',
        'per_user_limit',
        'apply_to',
        'is_active'
    ];
    
    protected $casts = [
        'discount_value' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'usage_limit' => 'integer',
        'usage_count' => 'integer',
        'per_user_limit' => 'integer',
        'is_active' => 'boolean',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime'
    ];
    
    // Methods
    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }
        
        $now = Carbon::now();
        
        if ($this->valid_from && $now->lt($this->valid_from)) {
            return false;
        }
        
        if ($this->valid_to && $now->gt($this->valid_to)) {
            return false;
        }
        
        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return false;
        }
        
        return true;
    }
    
    public function calculateDiscount($amount)
    {
        if (!$this->isValid() || $amount < $this->min_order_amount) {
            return 0;
        }
        
        $discount = 0;
        
        switch ($this->discount_type) {
            case 'percentage':
                $discount = $amount * ($this->discount_value / 100);
                break;
                
            case 'fixed':
                $discount = $this->discount_value;
                break;
                
            case 'free_shipping':
                // Handle free shipping logic
                $discount = 0; // This would be shipping fee
                break;
        }
        
        // Apply max discount limit
        if ($this->max_discount_amount && $discount > $this->max_discount_amount) {
            $discount = $this->max_discount_amount;
        }
        
        return $discount;
    }
    
    public function canUse($userId)
    {
        if (!$this->isValid()) {
            return false;
        }
        
        if ($this->per_user_limit > 0) {
            $usageCount = CouponUsage::where('coupon_id', $this->id)
                ->where('user_id', $userId)
                ->count();
                
            if ($usageCount >= $this->per_user_limit) {
                return false;
            }
        }
        
        return true;
    }
    
    public function incrementUsage()
    {
        $this->increment('usage_count');
    }
}