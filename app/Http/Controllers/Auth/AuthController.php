<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function post_login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Harap masukkan email / username',
            'password.required' => 'Harap masukkan kata sandi'
        ]);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $remember = $request->remember ? true : false;

        if (Auth::attempt([$fieldType => $request->username, 'password' => $request->password], $remember)) {
            return redirect(route('app.dashboard.index'))->with('success', 'Berhasil Masuk!');
        } else {
            return redirect(route('auth.login'))->with('alert-error', ucfirst($fieldType) . ' / Kata Sandi salah!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('auth.login'))->with('alert-success', ' Berhasil Keluar');
    }

    public function forgot()
    {
        return view('auth.forgot');
    }

    public function reset($email, $token)
    {
        return view('auth.reset');
    }
}
