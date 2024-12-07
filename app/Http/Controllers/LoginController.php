<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class LoginController extends Controller
{
    public function login()
    {
        return view('home.home'); // Mengarahkan ke view home
    }

    // Proses login
    public function authenticate(Request $request)
    {
       // Validasi input
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Cek apakah user aktif
    $user = User::where('email', $request->email)->first();

    if ($user && $user->status_id != 1) { // Cek status_id, 1 = Aktif
        return back()->with('error', 'Akun Anda telah dinonaktifkan.')->onlyInput('email');
    }
    

    // Proses autentikasi
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Redirect berdasarkan role
        $user = Auth::user();
        if ($user->role_id == 1) { // Admin
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->role_id == 2) { // Editor
            return redirect()->intended(route('editor.dashboard'));
        } else { // Member
            return redirect()->intended(route('home'));
        }
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        // Hapus session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman utama
        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }

    //registrasi member
    public function register(Request $request) {
        // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ]);

    // Simpan user dengan role member
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => 3, // Role Member
        'status_id' => 1, // Status Aktif
    ]);

    // Simpan detail user di session untuk pop-up
    session()->flash('user_details', [
        'name' => $user->name,
        'email' => $user->email,
        'password' => $user->password,
    ]);

    // Redirect ke halaman login
    return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
    
}
