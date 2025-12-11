<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CheckoutController extends Controller
{
    public function show($course_id)
    {
        $course = Course::findOrFail($course_id);
        return view('checkout', compact('course'));
    }
    
    public function process(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,course_id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'card_number' => 'required|string|size:16',
            'expiry_date' => 'required|string',
            'cvv' => 'required|string|size:3',
        ]);
        
        // Xử lý thanh toán ở đây (giả lập)
        
        return redirect()->route('enrollment.success')
                        ->with('success', 'Enrollment successful! Check your email for course access.');
    }
}