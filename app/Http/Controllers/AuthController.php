<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Siswa;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cek di tabel Admin
        $admin = Admin::where('username', $request->username)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::login($admin);
            session(['role' => 'admin']);
            return redirect('/admin/dashboard');
        }

        // Cek di tabel Siswa
        $siswa = Siswa::where('nomor_ujian', $request->username)->first();
        if ($siswa && Hash::check($request->password, $siswa->password)) {
            Auth::login($siswa);
            session(['role' => 'siswa']);
            return redirect('/siswa/dashboard');
        }

        return back()->withErrors(['nomor_ujian' => 'Username atau Password salah']);
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect('/login');
    }
}
