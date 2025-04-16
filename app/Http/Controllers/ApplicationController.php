<?php
namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{


    public function index()
    {
        $user = Auth::user();
    
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to view applications.');
        }
    
        $applications = Application::where('user_id', $user->id)->with('job')->get();
    
        return view('application.index', compact('applications')); 
    }



    public function create($jobId)
    {
        $job = Job::findOrFail($jobId);
        return view('application.create', compact('job')); // Fix view folder name
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



    // Sanitize and store resume if it exists
    if ($request->hasFile('resume')) {
        $resumeFile = $request->file('resume');
        $resumeFilename = Str::slug($resumeFile->getClientOriginalName(), '-') . '.' . $resumeFile->getClientOriginalExtension();
        $resumePath = $resumeFile->storeAs('resumes', $resumeFilename, 'public');
    }

      // Sanitize and store cover letter if it exists
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
    // Decode the filename (to handle special characters and spaces)
    $filename = urldecode($filename);

    // Ensure type is either 'resumes' or 'cover_letters'
    if (!in_array($type, ['resumes', 'cover_letters'])) {
        abort(404, 'Invalid file type');
    }

    // Define the full file path (make sure the path is correct for your environment)
    $filePath = storage_path("app/public/{$type}/{$filename}");

    // Check if the file exists
    if (file_exists($filePath)) {
        // Return the file to be viewed (not downloaded)
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

    return back()->with('success', 'Application status updated.');
}

public function pendingApplications()
{
    // Get the logged-in employer
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Please log in first.');
    }

    // Get the pending applications for the employer's jobs
    $applications = Application::with(['user', 'job']) // Explicitly load 'user' and 'job' relations
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



}
