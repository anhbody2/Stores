<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HuyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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
Route::get('/products/supper-pro-vip', [ProductController::class, 'showSupperProVIP']);
