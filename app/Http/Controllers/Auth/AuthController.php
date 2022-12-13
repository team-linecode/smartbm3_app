<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    private $emailTo;
    private $verifyToken;
    private $expiredToken;

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('app.dashboard.index');
        }

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

    public function post_forgot(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email'
            ],
            [
                'email.required' => 'Harap mengisi email',
                'email.email' => 'Format email tidak valid'
            ]
        );

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (!is_null($user->verify_token) && !is_null($user->expired_token)) {
                if ($user->expired_token > time()) {
                    return back()->with('error', 'Silahkan cek email untuk mengubah password');
                } else {
                    return back()->with('error', 'Token expired! silahkan masukkan email untuk menerima link reset passwords');
                }
            } else {
                $this->emailTo = $request->email;
                $this->verifyToken = Str::uuid();
                $this->expiredToken = time() + (60 * 60);

                if ($this->sendMail()) {
                    $user->verify_token = $this->verifyToken;
                    $user->expired_token = $this->expiredToken;
                    $user->update();

                    return back()->with('alert-success', 'Link reset password berhasil dikirim ke email anda, hanya berlaku selama 1 jam');
                }
            }
        } else {
            return back()->with('error', 'Alamat email tidak ditemukan');
        }
    }

    private function sendMail()
    {
        if (!$this->emailTo && !$this->verifyToken && !$this->expiredToken) {
            return false;
        } else {
            Mail::to($this->emailTo)->send(new \App\Mail\ResetPassEmail([
                'link' => url('/reset_password/' . $this->verifyToken),
            ]));

            return true;
        }
    }

    public function reset($verify_token)
    {
        $user = User::where('verify_token', $verify_token)->first();

        if (!$user) {
            return redirect(route('auth.login'))->with('error', 'Data tidak valid');
        } else {
            if ($user->expired_token < time()) {
                return redirect(route('auth.login'))->with('alert-error', 'Token expired! Silahkan melakukan request ulang');
            }
        }

        return view('auth.reset', [
            'verify_token' => $verify_token
        ]);
    }

    public function post_reset($verify_token, Request $request)
    {
        $user = User::where('verify_token', $verify_token)->first();

        if (!$user) {
            return redirect(route('auth.login'))->with('error', 'Data tidak valid');
        } else {
            if ($user->expired_token < time()) {
                return redirect(route('auth.login'))->with('alert-error', 'Token expired! Silahkan melakukan request ulang');
            }
        }

        $request->validate(
            [
                'password' => 'required|min:6',
                'repeat_password' => 'required|same:password'
            ],
            [
                'password.required' => 'Harap masukkan password baru',
                'password.min' => 'Password minimal memiliki 6 karakter',
                'repeat_password.required' => 'Harap masukkan ulang password baru',
                'repeat_password.same' => 'Password tidak sama',
            ]
        );

        $user->password = bcrypt($request->password);
        $user->no_encrypt = $request->password;
        $user->verify_token = NULL;
        $user->expired_token = NULL;
        $user->update();

        return redirect(route('auth.login'))->with('alert-success', 'Reset password berhasil! Silahkan login');
    }
}
