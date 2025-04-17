<?php
namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{

    public function allApplications()
    {
        $user = Auth::user();
    
        // Check if the user is an admin
        if ($user->role !== 'admin') {
            abort(403, 'Access denied');
        }
    
        // Admin can view all applications
        $applications = Application::with('user','job')->get();
    
        return view('admin.applications.all', compact('applications'));
    }

    public function show(Application $application)
{
    // Ensure the application is loaded with its related job and user
    $application->load('job', 'user');

    return view('admin.applications.show', compact('application'));
}



    
    public function index()
    {
        $user = Auth::user();
    
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to view applications.');
        }
    
        $applications = Application::where('user_id', $user->id)->with('job')->get();
    
        return view('application.index', compact('applications')); 
    }


    public function allPendingApplications()
{
    $user = Auth::user();

    // Check if the user is an admin
    if ($user->role !== 'admin') {
        abort(403, 'Access denied');
    }

    // Admin can view all pending applications across all jobs
    $applications = Application::with('user', 'job')->where('status', 'pending')->get();

    return view('admin.applications.pending', compact('applications'));
}


public function allApprovedApplications()
{
    $applications = Application::with(['user', 'job'])->where('status', 'approved')->get();
    return view('admin.applications.approved', compact('applications'));
}


    public function create($jobId)
    {
        $job = Job::findOrFail($jobId);
        return view('application.create', compact('job')); 
    }

    public function allRejectedApplications()
    {
        $applications = Application::with(['user', 'job'])->where('status', 'rejected')->get();
        return view('admin.applications.rejected', compact('applications'));
    }

    public function edit($id)
{
    // Retrieve the application by ID
    $application = Application::findOrFail($id);

    // Return the edit view and pass the application data to it
    return view('admin.applications.edit', compact('application'));
}

public function updateApp(Request $request, $id)
{
    // Validate the input data
    $request->validate([
        'status' => 'required|in:pending,approved,rejected',  // Ensure status is one of the defined values
        'notes' => 'nullable|string',  // Validate notes as optional text
    ]);

    // Find the application by ID
    $application = Application::findOrFail($id);

    // Update the application fields
    $application->status = $request->status; // Update the status
    $application->notes = $request->notes; // Update the notes if provided
    $application->save(); // Save the changes to the database

    // Redirect to the approved applications page with a success message
    return redirect()->route('admin.applications.approved')->with('success', 'Application updated successfully.');
}
 

    public function store(Request $request, $jobId)
    {
    
        $request->validate([
            'cover_letter' => 'nullable|mimes:pdf,doc,docx|max:2048',
            'resume' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ], [
            'resume.mimes' => 'Only PDF, DOC, or DOCX files are allowed.',
        ],
        [
            'cover_letter.mimes' => 'Only PDF, DOC, or DOCX files are allowed.',
        ]);
        

        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        $coverLetterPath = null;
      if  ($request->hasFile('cover_letter')) {
    $coverLetterPath = $request->file('cover_letter')->store('cover_letters', 'public');
}



  
    if ($request->hasFile('resume')) {
        $resumeFile = $request->file('resume');
        $resumeFilename = Str::slug($resumeFile->getClientOriginalName(), '-') . '.' . $resumeFile->getClientOriginalExtension();
        $resumePath = $resumeFile->storeAs('resumes', $resumeFilename, 'public');
    }


      if ($request->hasFile('cover_letter')) {
        $coverLetterFile = $request->file('cover_letter');
        $coverLetterFilename = Str::slug($coverLetterFile->getClientOriginalName(), '-') . '.' . $coverLetterFile->getClientOriginalExtension();
        $coverLetterPath = $coverLetterFile->storeAs('cover_letters', $coverLetterFilename, 'public');
    }

        Application::create([
            'job_id' => $jobId,
            'user_id' => Auth::id(),
            'cover_letter' => $coverLetterPath,
            'resume' => $resumePath,  
        ]);

        return redirect()->route('application.index')->with('success', 'Application submitted successfully!');
    } 



    public function viewFile($application, $type, $filename)
{
    
    $filename = urldecode($filename);


    if (!in_array($type, ['resumes', 'cover_letters'])) {
        abort(404, 'Invalid file type');
    }


    $filePath = storage_path("app/public/{$type}/{$filename}");

    // Check if the file exists
    if (file_exists($filePath)) {
       
        return response()->file($filePath);
    }

    // If file doesn't exist, return a 404 error
    abort(404, 'File not found');
}




    public function update(Request $request, Application $application)
{
    $request->validate([
        'status' => 'required|in:pending,approved,rejected',
    ]);

    $application->update([
        'status' => $request->status,
    ]);

    if ($application->status == 'approved') {
        return redirect()->route('admin.applications.approved')->with('success', 'Application approved successfully.');
    } elseif ($application->status == 'rejected') {
        return redirect()->route('admin.applications.rejected')->with('success', 'Application rejected successfully.');
    } else {
        return redirect()->route('admin.applications.pending')->with('success', 'Application status updated to pending.');
    }
}

public function pendingApplications()
{
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Please log in first.');
    }

    // Get the pending applications for the employer's jobs
    $applications = Application::with(['user', 'job']) 
        ->whereHas('job', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('status', 'pending')
        ->get();

    return view('application.pending', compact('applications'));
}


public function approve(Application $application)
{
    // Ensure that only the employer who owns the job can approve
    if ($application->job->user_id !== auth()->id()) {
        abort(403);
    }

    $application->status = 'approved';
    $application->save();

    return redirect()->back()->with('success', 'Application approved successfully.');
}

public function reject(Application $application)
{
    // Ensure that only the employer who owns the job can reject
    if ($application->job->user_id !== auth()->id()) {
        abort(403);
    }

    // Change the application status to 'rejected'
    $application->status = 'rejected';
    $application->save();

 
    return redirect()->back()->with('success', 'Application rejected successfully.');
}


public function approvedApplications()
{
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Please log in first.');
    }

    $applications = Application::with(['user', 'job'])
        ->whereHas('job', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('status', 'approved')
        ->get();

    return view('application.approved', compact('applications'));
}



public function rejectedApplications()
{
    
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Please log in first.');
    }

    // Get the rejected applications for the employer's jobs
    $applications = Application::with(['user', 'job'])
        ->whereHas('job', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('status', 'rejected')
        ->get();

    return view('application.rejected', compact('applications'));
}

public function userPendingApplications()
{
    $applications = Application::where('user_id', auth()->id())
        ->where('status', 'pending')
        ->latest()
        ->get();

    return view('user.applications.pending', compact('applications'));
}

public function userApprovedApplications()
{
    $applications = Application::where('user_id', auth()->id())
        ->where('status', 'approved')
        ->latest()
        ->get();

    return view('user.applications.approved', compact('applications'));
}

public function userRejectedApplications()
{
    $applications = Application::where('user_id', auth()->id())
        ->where('status', 'rejected')
        ->latest()
        ->get();

    return view('user.applications.rejected', compact('applications'));
}



}
