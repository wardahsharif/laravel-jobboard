<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function process(Request $request)
    {
        // Store job info temporarily in session
        Session::put('job_data', $request->only([
            'title', 'company', 'location', 'salary', 'type', 'description'
        ]));

        // Redirect to Paystack custom link
        return redirect('https://paystack.com/pay/jobseek');
    }

    public function callback(Request $request)
    {
        // Check if session has job data
        if (!Session::has('job_data')) {
            return redirect()->route('home')->with('error', 'Job data not found.');
        }

        $jobData = Session::get('job_data');
        $jobData['user_id'] = auth()->id(); // Assuming only logged-in users post jobs

        // Save to DB
        \App\Models\Job::create($jobData);

        Session::forget('job_data');

        return redirect()->route('jobs.index')->with('success', 'Job posted successfully!');
    }
}
