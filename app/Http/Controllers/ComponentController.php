<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comments;
use App\Models\Course;

class ComponentController extends Controller
{
    public function getAbout()
    {
        $users =  User::all();
        return view(
            'components.about',
            [
                'users' => $users,

            ]
        );
    }
    public function getMain()
    {
        $courses = Course::all();
        $users =  User::all();
        return view(
            'main_page.main2',
            [
                'courses' => $courses,
                'users' => $users,

            ]
        );
    }
    public function getContact()
    {
        $users =  User::all();
        return view(
            'components.contact',
            [
                'users' => $users,

            ]
        );
    }
    public function store(Request $request)
    {

        try {


            $input = $request->validate([
                'user_id' => 'required|integer',
                'comment' => 'required|string|max:1000',
            ]);

            Comments::create($input);

            return redirect('/contact')->with('toastMessage', 'Feedback thành công.')
                ->with('toastRedirect', '');
        } catch (\Exception $e) {
            echo "<script>console.log('Feedback Failed: " . $e->getMessage() . "');</script>";
            return redirect('/contact')->with('toastMessage', $e->getMessage())
                ->with('toastRedirect', '');
        }
    }
    public function getTeam()
    {

        $users =  User::all();
        return view('components.team', [
            'users' => $users,
        ]);
    }
    public function getTestimonial()
    {
        $users = User::all();
        $comments = Comments::all();
        return view(
            'components.testimonial',
            [
                'users' => $users,
                'comments' => $comments,
            ]
        );
    }
    public function getError()
    {
        return view('components.error');
    }
}
