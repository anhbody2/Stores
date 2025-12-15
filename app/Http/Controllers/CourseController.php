<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\Difficult;
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
                'id' => $course->course_id,
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
                'courses_count' => $course->courses_count,
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

    /**
     * Hiển thị chi tiết khóa học
     */
    public function show($id)
    {
        $course = Course::where('course_id', $id)->firstOrFail();

        $category = Category::where('category_id', $course->level)->first();
        $difficulty = Difficult::find($course->difficulty);

        return view('detail', [
            'course' => $course,
            'category_name' => $category->category_name ?? 'Unknown',
            'difficulty_name' => $difficulty->name ?? 'Unknown'
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

        return redirect()->back()->with('success', 'Course added successfully!');
    }
    public function softDelete($id)
    {
        $course = Course::find($id);
        $course->delete();
        return redirect()->back()->with('success', 'Course added successfully!');
    }
}
