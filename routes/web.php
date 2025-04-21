<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Models\Job;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PaymentController;



// Dashboard
Route::get('/', function () {

    // Fetch the featured jobs
    $featuredJobs = Job::where('status', 'active')->take(3)->get();
    
    return Auth::check() 
        ? redirect()->route('dashboard') 
        : view('welcome', compact('featuredJobs')); 
})->name('home');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');



// Authentication 
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Forgot Password & Reset 
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');

// Confirm Password 
Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show'); // View profile (read-only)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Update profile
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Delete account
});

// Admin Manage regular users 
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'userIndex'])->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::get('/admin/users/{id}', [AdminController::class, 'showUser'])->name('admin.users.show');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store'); 
});

// Admin Manage Employer Users
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/employers', [AdminController::class, 'employerIndex'])->name('admin.employer.index');
    Route::get('/admin/employers/{user}/edit', [AdminController::class, 'editEmployer'])->name('admin.employer.edit');
    Route::put('/admin/employers/{user}', [AdminController::class, 'updateEmployer'])->name('admin.employer.update');
    Route::delete('/admin/employers/{user}', [AdminController::class, 'destroyEmployer'])->name('admin.employer.destroy');
Route::get('/admin/employers/{id}', [AdminController::class, 'showEmployer'])->name('admin.employer.show');
Route::get('/admin/all-users', [AdminController::class, 'allUsers'])->name('admin.all-users');



});

// Job Routes for All  Users
Route::middleware('auth')->group(function () {
    Route::get('jobs', [JobController::class, 'index'])->name('jobs.index'); // List all jobs
    Route::get('jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::get('jobs/{job}', [JobController::class, 'show'])->name('jobs.show'); // Show job details
});



//Job access for Employer Routes 
Route::middleware(['auth', 'role:employer|admin'])->group(function () {
    Route::post('jobs', [JobController::class, 'store'])->name('jobs.store');
    Route::get('jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
    Route::put('jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
    Route::delete('jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
    Route::patch('/jobs/{job}/close', [JobController::class, 'close'])->name('jobs.close');
    Route::patch('/jobs/{job}/reopen', [JobController::class, 'reopen'])->name('jobs.reopen');
});



// Application Routes for all users
Route::middleware('auth')->group(function () {
    Route::get('/application', [ApplicationController::class, 'index'])->name('application.index');
    Route::get('/application/create/{jobId}', [ApplicationController::class, 'create'])->name('application.create');
    Route::post('/application/{jobId}', [ApplicationController::class, 'store'])->name('application.store');
    Route::patch('/application/{application}', [ApplicationController::class, 'update'])->name('application.update');
});



// Application route for admin and employer
Route::middleware(['auth', 'role:employer|admin'])->group(function () {
    Route::get('/application/pending', [ApplicationController::class, 'pendingApplications'])->name('application.pending');
    Route::post('/application/{application}/approve', [ApplicationController::class, 'approve'])->name('application.approve');
    Route::get('/application/approved', [ApplicationController::class, 'approvedApplications'])->name('application.approved');
    Route::get('/application/rejected', [ApplicationController::class, 'rejectedApplications'])->name('application.rejected');
    Route::post('/application/{application}/reject', [ApplicationController::class, 'reject'])->name('application.reject');
    Route::get('{application}/files/{type}/{filename}', [ApplicationController::class, 'viewFile'])->name('application.files.download');
    Route::get('{application}/files/{type}/{filename}', [ApplicationController::class, 'viewFile'])->name('application.files.download');
});



// Application routes for admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/applications/all', [ApplicationController::class, 'allApplications'])->name('admin.applications.all');
    Route::get('/admin/applications/pending', [ApplicationController::class, 'allPendingApplications'])->name('admin.applications.pending');
    Route::get('/admin/applications/approved', [ApplicationController::class, 'approvedApplications'])->name('admin.applications.approved');
    Route::get('/admin/applications/rejected', [ApplicationController::class, 'rejectedApplications'])->name('admin.applications.rejected');
    Route::get('/admin/applications/{application}', [ApplicationController::class, 'show'])->name('admin.applications.show');
    Route::get('/admin/applications/{application}/edit', [ApplicationController::class, 'edit'])->name('admin.applications.edit');
    Route::get('/admin/applications/{application}/file/{type}/{filename}', [ApplicationController::class, 'viewFile'])->name('admin.applications.viewFile');
    Route::get('/admin/applications/rejected', [ApplicationController::class, 'allRejectedApplications'])->name('admin.applications.rejected');
    Route::get('/admin/applications/approved', [ApplicationController::class, 'allApprovedApplications'])->name('admin.applications.approved');
    Route::put('/admin/application/{application}', [ApplicationController::class, 'update'])->name('admin.applications.update');


});


// User specific application route
Route::get('/user/applications/pending', [ApplicationController::class, 'userPendingApplications'])->name('user.applications.pending');
Route::get('/user/applications/approved', [ApplicationController::class, 'userApprovedApplications'])->name('user.applications.approved');
Route::get('/user/applications/rejected', [ApplicationController::class, 'userRejectedApplications'])->name('user.applications.rejected');


//payment route

Route::post('/payments/process', [PaymentController::class, 'process'])->name('payments.process');
Route::get('/payments/callback', [PaymentController::class, 'callback'])->name('payments.callback');

