<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;
use App\Models\User;

class DashboardController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard(); // Calls the admin dashboard
        } elseif ($user->isEmployer()) {
            return $this->employerDashboard(); // Calls the employer dashboard
        } elseif ($user->isUser()) {
            return $this->userDashboard(); // Calls the user dashboard
        }

        abort(403); // If no role matched, show a forbidden page
    }

    public function employerDashboard()
    {
        // Get the logged-in employer
        $user = auth()->user();


        if (!$user) {
            abort(403, 'Unauthorized: No user is logged in.');
        } 
        // Get the active and closed jobs for the employer
        $activeJobs = Job::where('user_id', $user->id)->where('status', 'active')->count();
        $closedJobs = Job::where('user_id', $user->id)->where('status', 'closed')->count();

        // Get the pending applications for the employer's jobs
        $pendingApplications = Application::whereHas('job', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'pending')->get();

        $approvedApplications = Application::with('job')
        ->whereHas('job', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('status', 'approved')
        ->get();

        return view('employer.dashboard', compact('activeJobs', 'closedJobs', 'pendingApplications','approvedApplications','user'));
    }

    public function userDashboard()
    {
        // Get the logged-in user
        $user = auth()->user();

        // Get the applications for the user
        $applications = Application::where('user_id', $user->id)->get();

        return view('user.dashboard', compact('applications'));
    }

    public function adminDashboard()
    {
        // Get the admin overview
        $totalUsers = User::count();
        $totalJobs = Job::count();
        $totalApplications = Application::count();

        return view('admin.dashboard', compact('totalUsers', 'totalJobs', 'totalApplications'));
    }
}
