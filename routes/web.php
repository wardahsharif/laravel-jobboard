<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\jobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\EmployerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//dashboard

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    if (Auth::user()->hasRole('admin')) {
        return view('admin.dashboard'); // This is the admin dashboard view
    } elseif (Auth::user()->hasRole('employer')) {
        return view('employer.dashboard'); // This is the employer dashboard view
    } elseif (Auth::user()->hasRole('user')) {
        return view('user.dashboard'); // This is the user dashboard view
    }
})->middleware(['auth'])->name('dashboard'); 

// Registration
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Login
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Forgot Password & Reset
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');

// Confirm Password
Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);



// Profile Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show'); // View profile (read-only)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Update profile
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Delete account
});


//user job routes 

Route::middleware('auth')->group(function () {
    Route::get('jobs', [jobController::class, 'index'])->name('jobs.index'); // List all jobs
    Route::get('jobs/{job}', [jobController::class, 'show'])->name('jobs.show'); // Show job details
});


//employer job route

// Only employers can create/edit/delete jobs
Route::middleware(['auth', 'role:employer'])->group(function () {
    Route::get('jobs/create', [jobController::class, 'create'])->name('jobs.create');
    Route::post('jobs', [jobController::class, 'store'])->name('jobs.store');
    Route::get('jobs/{job}/edit', [jobController::class, 'edit'])->name('jobs.edit');
    Route::put('jobs/{job}', [jobController::class, 'update'])->name('jobs.update');
    Route::delete('jobs/{job}', [jobController::class, 'destroy'])->name('jobs.destroy');
});



//Application routes

Route::middleware('auth')->group(function () {
    Route::get('/application', [ApplicationController::class, 'index'])->name('application.index');
    Route::get('/application/create/{jobId}', [ApplicationController::class, 'create'])->name('application.create');
    Route::post('/application/{jobId}', [ApplicationController::class, 'store'])->name('application.store');
});

// Privileges

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->middleware('role:admin');

    Route::get('/employer/dashboard', function () {
        return view('employer.dashboard');
    })->middleware('role:employer');

    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->middleware('role:user');
});