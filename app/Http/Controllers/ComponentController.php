<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComponentController extends Controller
{
     public function getAbout()
    {
        return view('components.about');
    }
    public function getContact()
    {
    return view('components.contact');
}
public function getTeam()
{
    return view('components.team');
}
public function getTestimonial()
{
    return view('components.testimonial');
}
}
