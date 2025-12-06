<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HuyController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('main_page.main');
});
Route::get('/login', [App\Http\Controllers\UserController::class, 'GetLogin']);

Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);

Route::get('/register', [App\Http\Controllers\UserController::class, 'GetUser']);

Route::post('/register', [App\Http\Controllers\UserController::class, 'register']);

Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');

Route::get('/huy', [HuyController::class, 'index']);
Route::get('/san-pham/supper-pro-vip', [ProductController::class, 'showSupperProVIP']);
Route::get('/products/supper-pro-vip', [ProductController::class, 'showSupperProVIP']);
