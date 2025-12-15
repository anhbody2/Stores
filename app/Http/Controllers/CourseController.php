<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\Difficult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    public function index()
    {
        $totalCourses = Course::count();
        $difficulties = Difficult::all();
        $courses = Course::all();
        $categories = Category::withCount('courses')->get()->map(function ($category) use ($totalCourses) {
            $category->percentage = $totalCourses > 0
                ? round(($category->courses_count / $totalCourses) * 100, 2)
                : 0;

            return $category;
        });
        $coursesJson = Course::all()->map(function ($course) use ($categories, $difficulties) {
            return [
                'course_id' => $course->course_id,
                'name' => $course->name,
                'title' => $course->name,
                'description' => $course->description,
                'image' => $course->image,
                'tutors' => $course->tutors,
                'rate' => $course->rate,
                'star_html' => star_rating($course->rate),
                'time_average' => $course->time_average,
                'price' => $course->price,
                'enrolled' => $course->enrolled,

                'category' => $course->level,
                'category_name' => optional(
                    $categories->firstWhere('category_id', $course->level)
                )->category_name ?? 'Unknown',
                'difficulty' => $course->difficulty,
                'difficulty_name' => optional(
                    $difficulties->firstWhere('id', $course->difficulty)
                )->name ?? 'Unknown'
            ];
        });

        return view('courses_page.courses', [
            'difficulties' => $difficulties,
            'courses' => $courses,
            'coursesJson' => $coursesJson,
            'categories' => $categories
        ]);
    }

    public function show($id)
{
    $course = Course::where('course_id', $id)->firstOrFail();

    $category = Category::where('category_id', $course->level)->first();
    $difficulty = Difficult::find($course->difficulty);

    // Kiểm tra user đã enroll chưa (từ enrolled_courses)
    $isEnrolled = false;

    if (Auth::check()) {
        $user = Auth::user();
        $enrolled = $this->getEnrolledCourseIds($user);
        $isEnrolled = in_array($course->course_id, $enrolled);
    }

    return view('courses_page.detail', [
        'course' => $course,
        'category_name' => $category->category_name ?? 'Unknown',
        'difficulty_name' => $difficulty->name ?? 'Unknown',
        'isEnrolled' => $isEnrolled,
    ]);
}

    /**
     * Hiển thị trang checkout cho 1 khóa học
     */
   /**
 * Hiển thị trang checkout cho 1 khóa học
 */
public function checkout($id)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đăng ký khóa học');
    }

    $user = Auth::user();
    $course = Course::where('course_id', $id)->firstOrFail();

    // Kiểm tra đã enroll chưa (từ enrolled_courses)
    $enrolled = $this->getEnrolledCourseIds($user);
    if (in_array($course->course_id, $enrolled)) {
        return redirect()->route('course.show', $id)
            ->with('info', 'Bạn đã đăng ký khóa học này rồi!');
    }

    return view('checkout.index', [
        'course' => $course,
        'user' => $user,
        'subtotal' => $course->price,
        'total' => $course->price,
        'isSingleCourse' => true
    ]);
}
    /**
     * Xử lý thanh toán cho 1 khóa học - CHỈ LƯU COURSE_ID
     */
   public function processCheckout(Request $request, $id)
{
    DB::beginTransaction();
    
    try {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $course = Course::where('course_id', $id)->firstOrFail();

        // Kiểm tra lại đã enroll chưa (từ enrolled_courses)
        $enrolled = $this->getEnrolledCourseIds($user);
        if (in_array($course->course_id, $enrolled)) {
            return redirect()->route('course.show', $id)
                ->with('info', 'Bạn đã đăng ký khóa học này rồi!');
        }

        // Validate
        $request->validate([
            'payment_method' => 'required|in:direct,bank_transfer,momo',
        ]);

        // THÊM COURSE_ID VÀO enrolled_courses
        $enrolled[] = $course->course_id;
        
        // Lưu dạng JSON array đơn giản [1, 2, 3] vào enrolled_courses
        $user->enrolled_courses = json_encode($enrolled);
        $user->save();

        // Cập nhật số lượng enrolled của course
        DB::table('courses')
            ->where('course_id', $course->course_id)
            ->increment('enrolled');

        DB::commit();

        Log::info('Enrollment successful: User ' . $user->id . ' enrolled in course ' . $course->course_id);

        // Redirect đến trang success
        return redirect()->route('checkout.success')
            ->with('success', 'Đăng ký khóa học thành công!')
            ->with('enrolled_course_id', $course->course_id);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Checkout error: ' . $e->getMessage());
        return redirect()->back()
            ->withInput()
            ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
    }
}

    /**
     * Lấy danh sách course_id đã enroll từ remember_token
     */
   /**
 * Lấy danh sách course_id đã enroll từ enrolled_courses
 */
private function getEnrolledCourseIds($user)
{
    // ĐỌC TỪ enrolled_courses thay vì remember_token
    $enrolledCourses = $user->enrolled_courses;
    
    if (empty($enrolledCourses)) {
        return [];
    }
    
    // Nếu enrolled_courses là mảng JSON [1, 2, 3]
    $decoded = json_decode($enrolledCourses, true);
    
    if (is_array($decoded) && !empty($decoded)) {
        // Kiểm tra phần tử đầu tiên: nếu là số => mảng course_id
        if (isset($decoded[0]) && is_numeric($decoded[0])) {
            return $decoded;
        }
        // Nếu là mảng kết hợp (kiểu cũ) => trích xuất course_id
        $courseIds = [];
        foreach ($decoded as $item) {
            if (isset($item['course_id']) && is_numeric($item['course_id'])) {
                $courseIds[] = $item['course_id'];
            }
        }
        return $courseIds;
    }
    
    return [];
}

    /**
     * Phương thức enroll cũ (redirect đến checkout)
     */
    public function enroll(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Redirect đến trang checkout
        return redirect()->route('course.checkout', $id);
    }
}