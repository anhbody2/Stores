<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    
    protected $fillable = [
        'user_id',
        'course_id',
        'quantity',
        'unit_price',
        'session_id'
    ];
    
    protected $casts = [
        'unit_price' => 'decimal:2',
        'quantity' => 'integer'
    ];
    
    // Relationships
    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }
    
    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
    
    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }
    
    // Methods
    public function getItemTotalAttribute()
    {
        return $this->unit_price * $this->quantity;
    }
    
    public static function addToCart($userId, $courseId, $price, $sessionId = null)
    {
        // Check if already in cart
        $existing = self::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->first();
            
        if ($existing) {
            $existing->quantity += 1;
            return $existing->save();
        }
        
        return self::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'unit_price' => $price,
            'quantity' => 1,
            'session_id' => $sessionId
        ]);
    }
    
    public static function getCartTotal($userId)
    {
        return self::where('user_id', $userId)
            ->get()
            ->sum(function($item) {
                return $item->item_total;
            });
    }
}