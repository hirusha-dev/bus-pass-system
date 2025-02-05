@extends('layouts.layout')

@section('title', 'Home Page')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

    <div class="container">
        <h2>User Management</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->user_name }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
