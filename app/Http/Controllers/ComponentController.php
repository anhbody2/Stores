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
        return view('components.about',
    [   
            'users' => $users,

    ]);
    }
    public function getMain()
    {   
        $courses = Course::all();
        $users =  User::all();
        return view('main_page.main2',
    [
            'courses'=>$courses,
            'users' => $users,

    ]);
    }
    public function getContact()
    {
        return view('components.contact');
    }
    public function getTeam()
    {

        $users =  User::all();
        return view('components.team',[
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
}
