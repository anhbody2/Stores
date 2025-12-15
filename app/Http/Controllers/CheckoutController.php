<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang thành công sau thanh toán
     */
    public function success(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Lấy course_id vừa enroll từ session
        $enrolledCourseId = $request->session()->get('enrolled_course_id');
        
        // Lấy danh sách course_id đã enroll từ enrolled_courses
        $enrolledCourseIds = json_decode($user->enrolled_courses ?? '[]', true);
        
        // Lấy thông tin chi tiết các khóa học từ database
        $enrolledCourses = [];
        if (!empty($enrolledCourseIds)) {
            $enrolledCourses = Course::whereIn('course_id', $enrolledCourseIds)
                ->orderBy('course_id', 'desc')
                ->get();
        }
        
        // Lấy khóa học vừa đăng ký (nếu có)
        $latestCourse = null;
        if ($enrolledCourseId) {
            $latestCourse = Course::where('course_id', $enrolledCourseId)->first();
        }

        return view('checkout.success', [
            'user' => $user,
            'enrolledCourses' => $enrolledCourses,
            'latestCourse' => $latestCourse,
            'enrolledCount' => count($enrolledCourseIds)
        ]);
    }
}