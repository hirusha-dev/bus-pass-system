@extends('layouts.auth')

@section('title', 'Register')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <div class="nav">
        <h1>Bus Pass Management</h1>
    </div>

    <div class="container">
        <!-- Registration Form -->
        <div id="register-form">
            <h2>Create Account</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                <input type="text" name="user_name" placeholder="Username" value="{{ old('user_name') }}" required>
                <input type="password" name="password" placeholder="Password" value="{{ old('password') }}" required>
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                <button type="submit">Register</button>
            </form>

            <div class="switch-form">
                Already have an account? <a href="login" id="login-link">Login</a>
            </div>
        </div>
    </div>
@endsection
