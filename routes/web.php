<?php

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
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ComponentController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('main_page.main');
});

// Authentication routes
Route::get('/login', [UserController::class, 'GetLogin']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/register', [UserController::class, 'GetUser']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// ========== COURSE ROUTES ==========
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/course/{id}', [CourseController::class, 'show'])->name('course.show');
Route::get('/course/{id}/checkout', [CourseController::class, 'checkout'])->name('course.checkout');
Route::post('/course/{id}/checkout/process', [CourseController::class, 'processCheckout'])->name('course.checkout.process');
Route::post('/course/{id}/enroll', [CourseController::class, 'enroll'])->name('course.enroll');

// ========== CHECKOUT ROUTES ==========
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

// ========== PROFILE ROUTES ==========
Route::middleware(['auth'])->group(function () {
    Route::get('/course/{id}/learn', [CourseController::class, 'learn'])->name('course.learn');
    Route::get('/user', [ProfileController::class, 'index'])->name('user');
    Route::get('/profile', [ProfileController::class, 'redirectToUser'])->name('profile');
    Route::get('/my-courses', [ProfileController::class, 'myCourses'])->name('my.courses');
});

// ========== EXISTING ROUTES ==========
Route::get('/huy', [HuyController::class, 'index']);
Route::get('/san-pham/supper-pro-vip', [ProductController::class, 'showSupperProVIP']);
Route::get('/products/{:id}', [ProductController::class, 'showSupperProVIP']);

// Category and course creation
Route::get('/categories/create', [CategoryController::class, 'create']);
Route::post('/categories/store', [CategoryController::class, 'store']);


Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/create', [CourseController::class, 'create']);
Route::post('/courses/store', [CourseController::class, 'store']);
Route::get('/courses/{id}/edit', [CourseController::class, 'edit']);
Route::post('/courses/{id}/update', [CourseController::class, 'update']);
Route::post('/courses/{id}/delete', [CourseController::class, 'softDelete']);


// Component routes
Route::get('/about', [ComponentController::class, 'getAbout']);
Route::get('/contact', [ComponentController::class, 'getContact']);
Route::get('/team', [ComponentController::class, 'getTeam']);
Route::get('/testimonial', [ComponentController::class, 'getTestimonial']);

Route::get('/forgot-password', function () {
    return view('users_page.forgot-password');
});


Route::post('/forgot-password', [ForgotPasswordController::class, 'update'])
    ->name('forgot.password.update');
// Route for admin dashboard
Route::get('/admin/dashboard',[AdminController::class, 'index']);
Route::get('/testimonial', [ComponentController::class, 'getTestimonial']);
