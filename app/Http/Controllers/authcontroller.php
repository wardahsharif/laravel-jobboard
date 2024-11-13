<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    //Register User
   public function register(Request $request) {

    //Validate
$field = $request-> validate ([

    'username' => ['required', 'max:255'],
    'email' => ['required', 'max:255', 'email','unique:users'],
    'password' => ['required', 'min:3', 'confirmed']
]);

    //Register


 $user = User::create($field);
    

    //Login

Auth::login($user);

    //Redirect
   
return redirect() -> route('home');
    
   }


   // Login User

   public function login(Request $request) {
     
    //Validate
$field = $request-> validate ([

    'email' => ['required', 'max:255', 'email'],
    'password' => ['required']
]);


  // Try to login the user 

if(Auth::attempt($field, $request -> remember)) {
    return redirect()->intended();
} else {
    return back()->withError([
        'failed' => 'The provided credentials do not match our records.'
    ]);
}
   }

 
   //logout user

  public function logout(Request $request) {

    //Logout the user
  Auth::logout();

   //Invalidate user's session
 $request->session()->invalidate();
   
 //Regenerate CSRF token
 $request->session()->invalidate();

 //Redirect to home
 return redirect('/');

   }


}

