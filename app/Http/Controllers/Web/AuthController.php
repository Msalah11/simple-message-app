<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Method to display the login view
    public function login()
    {
        return view('auth.login'); // Returning the login view
    }

    // Method to handle the login attempt
    public function doLogin(AuthRequest $request)
    {
        // Extracting phone and password from the request
        $credentials = $request->only('phone', 'password');

        // Attempting to authenticate the user using provided credentials
        if (Auth::attempt($credentials)) {
            // Redirecting to the chat route upon successful authentication
            return redirect()->route('chat');
        }

        // Redirecting back to the login page with error message if authentication fails
        return redirect()->back()->withInput()->withErrors(['error' => __('Invalid credentials')]);
    }
}
