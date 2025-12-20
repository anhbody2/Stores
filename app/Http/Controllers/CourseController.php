<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\Difficult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\CourseVideo;
use App\Models\Comments;
use App\Models\User;

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
        $recentCourses = Course::orderBy('created_at', 'desc')->take(3)->get();
        $coursesJson = Course::all()->map(function ($course) use ($categories, $difficulties) {
            return [
                'id' => $course->course_id,
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
        $users = User::all();
        $comments = Comments::all();

        return view('courses_page.courses', [
            'users' => $users,
            'comments' => $comments,
            'recentCourses' => $recentCourses,
            'difficulties' => $difficulties,
            'courses' => $courses,
            'coursesJson' => $coursesJson,
            'categories' => $categories
        ]);
    }
    public function create()
    {
        $categories = Category::all();  // for dropdown
        return view('courses_page.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'rate' => 'nullable|numeric',
            'enrolled' => 'nullable|integer',
            'price' => 'required|numeric',
            'publish_status' => 'required|boolean',
            'description' => 'nullable|string',
            'tutor' => 'string|nullable',
            'level' => 'required|integer',
            'time_average' => 'nullable|integer',
            'image' => 'nullable',
        ]);

        $course = new Course();
        $course->name = $request->name;
        $course->rate = $request->rate;
        $course->enrolled = $request->enrolled;
        $course->price = $request->price;
        $course->publish_status = $request->publish_status;
        $course->description = $request->description;
        $course->tutors = $request->tutor;
        $course->level = $request->level;
        $course->time_average = $request->time_average;

        // Image Upload
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('images/courses'), $imageName);
            $course->image = 'images/courses/' . $imageName;
        } else if ($request->input('image')) {
            $course->image = $request->input('image');
        }

        $course->save();

        return redirect()->back()->with('success', 'Course added successfully!');
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
public function learn($id)
{
    // 1. Kiểm tra user đã đăng nhập chưa
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please login to access course videos');
    }

    $user = Auth::user();
    
    // 2. Kiểm tra user đã đăng ký khóa học này chưa
    $enrolled = $this->getEnrolledCourseIds($user);
    
    if (!in_array($id, $enrolled)) {
        return redirect()->route('course.show', $id)
            ->with('error', 'You need to enroll in this course first!');
    }
    
    // 3. Lấy thông tin khóa học
    $course = Course::where('course_id', $id)->firstOrFail();
    
    // 4. Lấy danh sách video từ bảng course_videos
    $courseVideo = CourseVideo::where('course_id', $id)->first();
    
    // 5. Parse video URLs từ JSON
    $videos = [];
    if ($courseVideo && !empty($courseVideo->videos)) {
        // Nếu đã cast trong model, nó sẽ tự động là array
        if (is_array($courseVideo->videos)) {
            $videos = $courseVideo->videos;
        } else {
            // Nếu chưa cast, decode JSON
            $videos = json_decode($courseVideo->videos, true);
            if (!is_array($videos)) {
                $videos = [];
            }
        }
    }
    
    // 6. Lấy category và difficulty
    $category = Category::where('category_id', $course->level)->first();
    $difficulty = Difficult::find($course->difficulty);
    
    return view('courses_page.learn', [
        'course' => $course,
        'videos' => $videos,
        'video_count' => count($videos),
        'category_name' => $category->category_name ?? 'Unknown',
        'difficulty_name' => $difficulty->name ?? 'Unknown',
    ]);
}
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
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $categories = Category::all();
        return view('courses_page.edit', compact('course', 'categories'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'rate' => 'nullable|numeric',
            'enrolled' => 'nullable|integer',
            'price' => 'required|numeric',
            'publish_status' => 'required|boolean',
            'description' => 'nullable|string',
            'level' => 'required|integer',
            'time_average' => 'nullable|integer',
            'image' => 'nullable',
        ]);
        $course = Course::findOrFail($request->id);
        $course->name = $request->name;
        $course->rate = $request->rate;
        $course->enrolled = $request->enrolled;
        $course->price = $request->price;
        $course->publish_status = $request->publish_status;
        $course->description = $request->description;
        $course->level = $request->level;
        $course->time_average = $request->time_average;

        // Image Upload
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('images/courses'), $imageName);
            $course->image = 'images/courses/' . $imageName;
        } else if ($request->input('image')) {
            $course->image = $request->input('image');
        }

        $course->save();

        return redirect('/admin/dashboard')->with('success', 'Course added successfully!');
    }
    public function softDelete($id)
    {
        $course = Course::find($id);
        $course->delete();
        return redirect()->back()->with('success', 'Course added successfully!');
    }
}
