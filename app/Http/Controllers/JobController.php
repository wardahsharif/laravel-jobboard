<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Display a listing of the jobs.
     */
    public function index()
    {
        $user = auth()->user(); 



        if ($user->role === 'employer') {
            // Employer see only their own jobs
            $jobs = Job::where('user_id', $user->id)->latest()->paginate();
    
            $activeJobs = Job::where('user_id', $user->id)
                             ->where('status', 'active')
                             ->count();
    
            $closedJobs = Job::where('user_id', $user->id)
                             ->where('status', 'closed')
                             ->count();
        } elseif ($user->role === 'admin') {
            // Admin: all jobs
            $jobs = Job::latest()->paginate();

        // Pass empty values or null for admin as these aren't needed
        $activeJobs = null;
        $closedJobs = null;

        return view('jobs.index', compact('jobs', 'activeJobs', 'closedJobs'));
            
        } else {
            // Regular user see only active jobs
            $jobs = Job::where('status', 'active')->latest()->paginate();
           
                  return view('jobs.index', compact('jobs'));
        }
    
        return view('jobs.index', compact('jobs', 'activeJobs', 'closedJobs'));

        $featuredJobs = Job::where('status', 'active')->take(3)->get(); 
        return view('welcome', compact('featuredJobs'));
    }

    /**
     * Show the form for creating a new job.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created job in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'type' => 'required|string|in:Full-time,Part-time,Freelance,Internship',
        ]);

        Job::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'company' => $request->company,
            'location' => $request->location,
            'salary' => $request->salary,
            'type' => $request->type,
        ]);

        return redirect()->route('jobs.index')->with('success', 'Job created successfully!');
    }

    /**
     * Display the specified job.
     */
    public function show(Job $job)
    {
        $job->load('applications.user');

        return view('jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified job.
     */
    public function edit(Job $job)
    {
        return view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified job in the database.
     */
    public function update(Request $request, Job $job)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'type' => 'required|string|in:Full-time,Part-time,Freelance,Internship',
        ]);

        $job->update($request->all());

        return redirect()->route('jobs.index')->with('success', 'Job updated successfully!');
    }




    public function close(Job $job)
{
    $user = auth()->user();

    if (!$user || ($user->role !== 'admin' && $user->id !== $job->user_id)) {
        abort(403, 'Unauthorized access: User does not have the required role');
    }

    $job->status = 'closed';
    $job->save();

    return back()->with('success', 'Job has been closed.');
}

    
public function reopen(Job $job)
{
    $user = auth()->user();

    if (!$user || ($user->role !== 'admin' && $user->id !== $job->user_id)) {
        abort(403, 'Unauthorized access: User does not have the required role');
    }

    $job->status = 'active';
    $job->save();

    return back()->with('success', 'Job reactivated successfully.');
}
    

    /**
     * Remove the specified job from the database.
     */
    public function destroy(Job $job)
    {
        

        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully!');
    }
}
