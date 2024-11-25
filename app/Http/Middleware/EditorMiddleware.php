<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditorMiddleware
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
        if (Auth::check() && Auth::user()->role_id == 2) {
            // Cek apakah status editor aktif
            if (Auth::user()->status_id == 1) {
                return $next($request);
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors(['error' => 'Akun Anda dinonaktifkan.']);
            }
        }

        return redirect()->route('login')->withErrors(['error' => 'Unauthorized access.']);
    }
}
