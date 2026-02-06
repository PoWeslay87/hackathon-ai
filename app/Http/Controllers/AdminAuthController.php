<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session('is_admin')) {
            return redirect()->route('dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Hackathon Simple Auth: admin / admin123
        if ($request->username === 'admin' && $request->password === 'admin123') {
            session(['is_admin' => true]);
            return redirect()->route('dashboard')->with('success', 'Selamat Datang, Administrator!');
        }

        return back()->with('error', 'Username atau Password salah.');
    }

    public function logout()
    {
        session()->forget('is_admin');
        return redirect()->route('login')->with('success', 'Berhasil keluar.');
    }
}
