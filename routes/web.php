<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'posts.index') ->name('home');


Route::get('/dashboard' , [dashboardController::class, 'index'])->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::view('/register', 'auth.register') ->name('register');


Route::post('/register' , [AuthController::class, 'register']);

Route::view('/login', 'auth.login') ->name('login');

Route::post('/login' , [AuthController::class, 'login']);


