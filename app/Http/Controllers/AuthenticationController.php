<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthenticationController extends Controller
{
    public function login() {
        return view('authenticate/login');
    }

    public function logout() {

        session(['current_username' => null]);
        session(['current_user_id' => null]);

        return view('user.index');
    }

    public function authenticate(Request $request) {

        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $user = User::where('username', '=', request('username'))->first();

            session(['current_username' => request('username')]);
            session(['current_user_id' => $user->id]);

            return redirect('advertisement/index');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
            'password' => 'The provided credentials do not match our records.',
        ]);

    }

}