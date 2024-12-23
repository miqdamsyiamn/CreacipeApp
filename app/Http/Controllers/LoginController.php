<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use Illuminate\Support\Facades\Validator;
use App\Mail\AccountDetailsMail;
use Illuminate\Support\Facades\Mail;


class LoginController extends Controller
{
    //login ke home
    public function login()
    {
        // Ambil resep dengan status_id = 2
        $approvedRecipes = \App\Models\Recipe::where('status_id', 2)->latest()->get();

        // Kirim status modal untuk menentukan modal mana yang dibuka
        $showLoginModal = session('showLoginModal', false);
        $showRegisterModal = session('showRegisterModal', false);

        return view('home.home', compact('approvedRecipes', 'showLoginModal', 'showRegisterModal'));
    }

    // Proses login
    public function authenticate(Request $request)
    {
        // Validasi input
        $validator = Validator::make(
            $request->all(),
            [
                'email' => ['required', 'email'],
                'password' => ['required'],
                'g-recaptcha-response' => ['required', 'captcha'],
            ],
            [
                'g-recaptcha-response.required' => 'Silakan konfirmasi bahwa Anda bukan robot.',
                'g-recaptcha-response.captcha' => 'Validasi reCAPTCHA gagal. Silakan coba lagi.',
            ]
        );

        // Jika validasi gagal, modal register muncul
        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator)
                ->with('showLoginModal', true);
        }

        // Cek apakah user aktif
        $user = User::where('email', $request->email)->first();

        if ($user && $user->status_id != 1) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Akun Anda telah dinonaktifkan.'])
                ->with('showLoginModal', true); // Tambahkan session untuk modal login
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role_id == 1) {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->role_id == 2) {
                return redirect()->intended(route('editor.dashboard'));
            } else {
                return redirect()->intended(route('home'));
            }
        }

        return redirect()->back()
            ->withErrors(['login_error' => 'Email atau password salah.'])
            ->with('showLoginModal', true)
            ->onlyInput('email');
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
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'g-recaptcha-response' => ['required', 'captcha'],
        ], [
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
            'password.min' => 'Password harus terdiri dari minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'g-recaptcha-response.required' => 'Silakan konfirmasi bahwa Anda bukan robot.',
            'g-recaptcha-response.captcha' => 'Validasi reCAPTCHA gagal. Silakan coba lagi.',
        ]);

        // Jika validasi gagal, modal register muncul
        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator)
                ->with('showRegisterModal', true); // Tampilkan modal register
        }

        // Simpan user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 3,
            'status_id' => 1,
            'profile_picture' => 'assets/images/profil/profil.jpg',
        ]);

        // Simpan detail user di session untuk pop-up
        session()->flash('user_details', [
            'name' => $user->name,
            'email' => $user->email,
        ]);

        // Kirim email dengan detail akun
        Mail::to($request->email)->send(new AccountDetailsMail($user, $request->password));

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
