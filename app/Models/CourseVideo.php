<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseVideo extends Model
{
    use HasFactory;

    protected $table = 'course_videos';
    
    protected $primaryKey = 'course_id';
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'course_id',
        'videos'
    ];
    
    protected $casts = [
        'videos' => 'array' // Tự động decode JSON
    ];
    
    /**
     * Relationship với bảng courses
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }
    
    /**
     * Lấy danh sách video dạng array
     */
    public function getVideosArrayAttribute()
    {
        if (empty($this->videos)) {
            return [];
        }
        
        return json_decode($this->videos, true);
    }
    
    /**
     * Lấy số lượng video
     */
    public function getVideoCountAttribute()
    {
        $videos = $this->getVideosArrayAttribute();
        return count($videos);
    }
}