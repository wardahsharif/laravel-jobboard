<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\PaystackService;



class PaymentController extends Controller
{
    public function process(Request $request, \App\Services\PaystackService $paystack)
    {
        // Store job info temporarily in session
        Session::put('job_data', $request->only([
            'title', 'company', 'location', 'salary', 'type', 'description'
        ]));

    
   
        $amount = 500 * 100; 
        $email = auth()->user()->email;

        
    $paystack = new PaystackService();
    $response = $paystack->initializePayment($amount, $email);

    if (!$response['status']) {
        return back()->with('error', 'Unable to initialize payment.');
    }

    // Redirect to the Paystack payment page
    return redirect($response['data']['authorization_url']);
    }



    public function callback(Request $request, PaystackService $paystack)
    {
        $reference = $request->query('reference');
    
        if (!$reference || !Session::has('job_data')) {
            return redirect()->route('jobs.create')->with('error', 'Invalid payment attempt.');
        }
    
        $response = $paystack->verifyPayment($reference);
    
        if (!$response['status'] || $response['data']['status'] !== 'success') {
            return redirect()->route('jobs.create')->with('error', 'Payment verification failed.');
        }

           // Save transaction
         \App\Models\Transaction::create([
        'user_id' => auth()->id(),
        'reference' => $response['data']['reference'],
        'amount' => $response['data']['amount'], // amount is in kobo
        'status' => $response['data']['status'], // e.g. 'success'
    ]);
    
        // Create job
        $jobData = Session::get('job_data');
        $jobData['user_id'] = auth()->id();
    
        \App\Models\Job::create($jobData);
    
        Session::forget('job_data');
    
        return redirect()->route('jobs.index')->with('success', 'Job posted successfully!');
    }
    



    public function preview(Request $request)
    {
        return view('payment.pay', ['job' => $request->all()]);
    }

    // For Employer
public function myTransactions()
{
    $transactions = auth()->user()->transactions()->latest()->get();
    return view('employer.transaction', compact('transactions'));
}

// For Admin
public function allTransactions()
{
    $transactions = \App\Models\Transaction::latest()->get();
    return view('admin.transaction', compact('transactions'));
}

    
}
