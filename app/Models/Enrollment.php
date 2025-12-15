<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'enrolled_at',
        'status',
        'progress'
    ];

    // Chuyển đổi enrolled_at thành Carbon instance
    protected $casts = [
        'enrolled_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Hoặc dùng mutator nếu cần
    protected function enrolledAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => \Carbon\Carbon::parse($value),
            set: fn ($value) => $value,
        );
    }

    // Quan hệ với course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // Quan hệ với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}