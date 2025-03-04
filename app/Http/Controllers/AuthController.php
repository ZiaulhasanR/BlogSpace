<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use  Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login logic
    public function login(Request $request)
    {

        // Validate input data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials, $request->has('remember'))) {
            Log::info($credentials);
             return redirect()->route("dashboard")->with('success', 'Logged in successfully');
        }

        // Redirect back with error message if credentials are invalid
        return back()->with('error', 'Invalid login credentials');
    }

    // Handle logout
    public function logout()
    {
        Auth::logout(); // Log out the user
        return redirect('/login')->with('success', 'Logged out successfully');
    }

    // Show the registration form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle user registration
    public function register(Request $request)
    {
        // Validate registration form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,user,author',

        ]);

        // Create the user and save to database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,

        ]);

        // Redirect to login page after successful registration
        return redirect()->route('login')->with('success', 'Registration successful! You can now log in.');
    }
}
