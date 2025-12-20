<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Hiển thị trang profile chính
     */
    public function index()
    {
        $user = auth()->user();
        
        // Lấy số lượng khóa học đã enroll từ enrolled_courses
        $enrolledCourseIds = json_decode($user->enrolled_courses ?? '[]', true);
        $enrollments_count = is_array($enrolledCourseIds) ? count($enrolledCourseIds) : 0;
        
        // Lấy 3 khóa học gần đây để hiển thị
        $recentCourses = [];
        if (!empty($enrolledCourseIds)) {
            $recentCourses = \App\Models\Course::whereIn('course_id', array_slice($enrolledCourseIds, -3))
                ->get();
        }
        
        return view('profile.index', [
            'user' => $user,
            'enrollments_count' => $enrollments_count,
            'recentCourses' => $recentCourses
        ]);
    }
    
    /**
     * Redirect từ /profile đến /user
     */
    public function redirectToUser()
    {
        return redirect('/user');
    }
    
    /**
     * Hiển thị tất cả khóa học đã mua
     */
    public function myCourses()
    {
        $user = auth()->user();
        
        // Lấy danh sách course_id từ enrolled_courses
        $enrolledCourseIds = json_decode($user->enrolled_courses ?? '[]', true);
        $enrollments_count = is_array($enrolledCourseIds) ? count($enrolledCourseIds) : 0;
        
        if (!is_array($enrolledCourseIds) || empty($enrolledCourseIds)) {
            $enrolledCourseIds = [];
        }
        
        // Lấy thông tin chi tiết khóa học từ bảng courses
        $courses = \App\Models\Course::whereIn('course_id', $enrolledCourseIds)->get();
        
        return view('profile.my-courses', [
            'user' => $user, 
            'courses' => $courses,
            'enrollments_count' => $enrollments_count,
            'totalCourses' => count($enrolledCourseIds)
        ]);
    }
}