@extends('layouts.auth')

@section('title', 'Login')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <div class="nav">
        <h1>Bus Pass Management</h1>
    </div>

    <div class="container">
        <!-- Login Form -->
        <div id="login-form">
            <h2>Login</h2>
            <form id="login-form" action="{{ route('login') }}" method="POST">
                @csrf
                <!-- Change form action to PHP login handler -->
                <input type="text" name="user_name" placeholder="Username" value="{{ old('user_name') }}" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit">Login</button>
            </form>

            <div class="switch-form">
                Don't have an account?
                <a href="/register" id="register-link">Create Account</a>
            </div>
            <div class="switch-form">
                <a href="{{ route('forgotPasswordPage') }}" id="forgot-password-link">Forgot Password?</a>
            </div>

        </div>
    </div>
@endsection
