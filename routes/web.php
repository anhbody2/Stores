<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [App\Http\Controllers\UserController::class, 'GetLogin']);

Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);

Route::get('/register', [App\Http\Controllers\UserController::class, 'GetUser']);

Route::post('/register', [App\Http\Controllers\UserController::class, 'register']);

Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');