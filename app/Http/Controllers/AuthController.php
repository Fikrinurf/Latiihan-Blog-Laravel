<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('blog.login')->with(['title' => 'Login']);
    }

    public function authenticate(Request $request)
    {
        $autentikasi = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email harus diisi',
                'email.email' => 'Masukan email yang valid',
                'password.required' => 'Password harus diisi',
            ]
        );

        if (Auth::attempt($autentikasi)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->with('Gagal', 'Email atau password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
