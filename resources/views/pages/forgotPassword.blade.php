@extends('layouts.auth')

@section('title', 'Forgot Password')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <div class="nav">
        <h1>Bus Pass Management</h1>
    </div>

    <div class="container">
        <div id="forgot-password-form">
            <h2>Reset Password</h2>
            <form action="{{ route('resetPassword') }}" method="POST">
                @csrf
                <input type="text" name="user_name" placeholder="Enter Your Username" value="{{ old('user_name') }}"
                    required />
                <input type="password" name="password" placeholder="New Password" required />
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required />
                <button type="submit">Reset Password</button>
            </form>

            <div class="switch-form">
                <a href="{{ route('loginPage') }}">Back to Login</a>
            </div>
        </div>
    </div>
@endsection
