<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('auth.passwords.change');
    }

    public function store(Request $request)
    {
        $request->validate([
            // * Include this if you want to require the original password in order to change
            // 'current_password' => ['required', 'password'],
            'password' => ['required', 'confirmed'],
        ]);

        $password = $request->get('password');
        $user = Auth::user();

        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        event(new PasswordReset($user));

        Auth::login($user);

        return redirect('home')->with('status', 'Password successfully updated');
    }
}
