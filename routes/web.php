<?php



use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;

use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('main_page.main');
});

// Authentication routes
Route::get('/register', [UserController::class, 'GetUser'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::get('/login', [UserController::class, 'GetLogin'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.post');

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
    Route::get('/user', [ProfileController::class, 'index'])->name('user');
    Route::get('/profile', [ProfileController::class, 'redirectToUser'])->name('profile');
    Route::get('/my-courses', [ProfileController::class, 'myCourses'])->name('my.courses');
});

// ========== EXISTING ROUTES ==========
Route::get('/huy', [HuyController::class, 'index']);
Route::get('/san-pham/supper-pro-vip', [ProductController::class, 'showSupperProVIP']);
Route::get('/products/{:id}', [ProductController::class, 'showSupperProVIP']);




Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/create', [CourseController::class, 'create']);
Route::post('/courses/store', [CourseController::class, 'store']);
Route::get('/courses/{id}/edit', [CourseController::class, 'edit']);
Route::post('/courses/{id}/update', [CourseController::class, 'update']);
Route::post('/courses/{id}/delete', [CourseController::class, 'softDelete'])->name('courses.delete');


// Component routes
Route::get('/about', [ComponentController::class, 'getAbout']);
Route::get('/contact', [ComponentController::class, 'getContact']);
Route::get('/team', [ComponentController::class, 'getTeam']);
Route::get('/testimonial', [ComponentController::class, 'getTestimonial']);
// Route for admin dashboard
Route::get('/admin/dashboard', [AdminController::class, 'index']);
Route::get('/testimonial', [ComponentController::class, 'getTestimonial']);
