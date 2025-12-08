<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;

class CourseController extends Controller
{   
    public function index()
    {
        $courses = Course::all();
        $categories = Category::all(); 

        return view('courses_page.courses', compact('courses', 'categories'));
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
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('images/courses'), $imageName);
            $course->image = 'images/courses/' . $imageName;
        }
        else if ($request->input('image')) {
            $course->image = $request->input('image');
        }

        $course->save();

        return redirect()->back()->with('success', 'Course added successfully!');
    }
}
