<?php
namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
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
            'cover_letter' => 'required|string',
            'resume' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ], [
            'resume.mimes' => 'Only PDF, DOC, or DOCX files are allowed.',
        ]);
        

        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        Application::create([
            'job_id' => $jobId,
            'user_id' => Auth::id(),
            'cover_letter' => $request->cover_letter,
            'resume' => $resumePath,  
        ]);

        return redirect()->route('application.index')->with('success', 'Application submitted successfully!');
    } 
}
