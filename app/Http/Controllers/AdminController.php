<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        // Giriş verilerini doğrula
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Giriş denemesi
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();  // BU ÇOK ÖNEMLİ
            return redirect()->intended(route('dashboard'));
        }

        // Başarısız giriş, hata mesajı ile geri dön
        return back()->withErrors(['email' => 'Email veya şifre hatalı!'])->withInput();
    }
}
