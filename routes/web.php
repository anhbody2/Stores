<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HuyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
Route::get('/', function () {
    return view('main_page.main');
});

Route::get('/register', [UserController::class, 'GetUser'])->name('register.form');
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::get('/login', [UserController::class, 'GetLogin'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.post');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/huy', [HuyController::class, 'index']);
Route::get('/course/{id}', [CourseController::class, 'show']);
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

Route::get('/forgot-password', function () {
    return view('users_page.forgot-password');
});


Route::post('/forgot-password', [ForgotPasswordController::class, 'update'])
    ->name('forgot.password.update');