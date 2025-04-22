<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile (read-only).
     */
    public function show(): View
    {
        return view('profile.show', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Display the user's profile form (edit).
     */
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user')); 
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }


    public function processPayment(Request $request)
{
   
    $payment = new Payment();
    $payment->user_id = auth()->id();  
    $payment->job_id = $request->job_id; 
    $payment->amount = $request->amount; 
    $payment->payment_method = $request->payment_method; 
    $payment->status = 'completed'; 
    $payment->save();

  
    $job = Job::find($request->job_id);
    $job->status = 'paid';
    $job->save();

    return redirect()->route('payments.success');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    
}
