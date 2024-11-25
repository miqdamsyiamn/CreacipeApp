<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Cek apakah user adalah admin
            if ($user->role_id == 1) {
                // Cek apakah status user aktif
                if ($user->status_id == 1) { // Status ID 1 untuk "aktif"
                    return $next($request); // Lanjutkan ke request berikutnya
                } else {
                    // Logout jika status tidak aktif
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['error' => 'Akun Anda dinonaktifkan.']);
                }
            }
        }
        // Redirect jika bukan admin atau belum login
        return redirect()->route('login')->withErrors(['error' => 'Unauthorized access.']);
    }
}
