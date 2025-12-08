<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showadminpage()
    {
        return view('admin_page.admin');
    }
}
