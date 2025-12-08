<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HuyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ComponentController;
Route::get('/', function () {
    return view('main_page.main');
});
Route::get('/login', [UserController::class, 'GetLogin']);

Route::post('/login', [UserController::class, 'login']);

Route::get('/register', [UserController::class, 'GetUser']);

Route::post('/register', [UserController::class, 'register']);

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/huy', [HuyController::class, 'index']);
Route::get('/san-pham/supper-pro-vip', [ProductController::class, 'showSupperProVIP']);
Route::get('/products/{:id}', [ProductController::class, 'showSupperProVIP']);

// route for category and course creation and storage
Route::get('/categories/create', [CategoryController::class, 'create']);
Route::post('/categories/store', [CategoryController::class, 'store']);

Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/create', [CourseController::class, 'create']);
Route::post('/courses/store', [CourseController::class, 'store']);

Route::get('/about', [ComponentController::class, 'getAbout']);
Route::get('/contact', [ComponentController::class, 'getContact']);
Route::get('/team', [ComponentController::class, 'getTeam']);
Route::get('/testimonial', [ComponentController::class, 'getTestimonial']);
