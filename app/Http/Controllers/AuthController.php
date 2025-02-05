<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Register new user
    public function register(Request $request)
    {
        // Validate inputs
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'user_name' => 'required|string|unique:users,user_name',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            // Get all validation error messages as a string
            $errors = implode('<br>', $validator->errors()->all());

            // Pass the error messages to toastr
            toastr()->error($errors);

            // Redirect back with input and errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_name' => $request->user_name,
            'password' => Hash::make($request->password),
        ]);

        // Show success message
        toastr()->success('Registration successful! You can now log in.');
        return redirect()->route('loginPage');
    }

    public function login(Request $request)
    {
        // Validate the login form data
        $request->validate([
            'user_name' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('user_name', 'password');

        // Attempt to log in
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect based on the user's role
            if ($user->role === 'admin') {
                toastr()->success('Welcome Admin!');
                return redirect()->route('admin.user-management');
            }

            toastr()->success('Welcome User!');
            return redirect()->route('homePage');


            return redirect()->route('loginPage')->withInput();
        }

        // Invalid credentials
        toastr()->error('Invalid username or password.');
        return back()->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Clear the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toastr()->success('Logout Successfully');
        return redirect()->route('loginPage');
    }

    // Show forgot password page
    public function showForgotPasswordPage()
    {
        return view('pages.forgotPassword');
    }

    // Handle password reset request
    public function resetPassword(Request $request)
    {
        // Validate input fields
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string|exists:users,user_name',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            // Get all validation error messages as a string
            $errors = implode('<br>', $validator->errors()->all());

            // Pass the error messages to toastr
            toastr()->error($errors);

            // Redirect back with input and errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find user by username
        $user = User::where('user_name', $request->user_name)->first();

        // Update the password
        $user->password = Hash::make($request->password);
        $user->save();

        toastr()->success('Password reset successfully! You can now log in.');

        return redirect()->route('loginPage');
    }
}
