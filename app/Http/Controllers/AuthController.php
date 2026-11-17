<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showlogin(Request $request)
    {
        if (Auth::check()) {
            return redirect("/admin/transaction");
        }

        return view("auth.login");
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate
        ([
                "email" => ["required", "email"],
                "password" => ["required"],
            ]);

        $remember = $request->boolean("remember");

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended("/admin/transactions")->with("success", "Selamat datang kembali di Seller Center," . Auth::user()->name . "!");
        }

        return back()->withErrors([
            "email" => "Kredensial tidak cocok. periksa kembali alamat email dan kata sandi anda",
        ])->onlyInput("email");
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect("/login")->with("status", "Anda telah berhasil keluar");
    }
}
