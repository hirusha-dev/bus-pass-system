<?php

namespace App\Http\Controllers;

use App\Models\BusPass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebPageController extends Controller
{
    public function home()
    {
        return view('pages.welcome');
    }
    public function register()
    {
        return view('pages.register');
    }
    public function login()
    {
        return view('pages.login');
    }
    public function generatePass()
    {
        $id = Auth::id();

        $user = User::where('id', $id)->first();

        return view('pages.generatePass', compact('user'));
    }
    public function viewPass()
    {
        $user_id = Auth::id();

        $pass = BusPass::where('user_id', $user_id)->first();

        return view('pages.viewPass', compact('pass'));
    }
}
