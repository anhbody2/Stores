<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Course extends Model
{
    public $timestamps = false;
    protected $table = 'courses';
    
    // THÊM DÒNG NÀY
    protected $primaryKey = 'course_id';
    
    // THÊM NÀY NỮA (tùy chọn)
    protected $fillable = [
        'name',
        'image',
        'rate',
        'enrolled',
        'price',
        'publish_status',
        'description',
        'level',
        'time_average',
        'tutors',
        'difficulty'
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'level');
    }
}