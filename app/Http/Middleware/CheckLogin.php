<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah user sudah login
        if (!session()->has('user_id')) {
            // Redirect ke halaman login jika belum login
            return redirect()->route('user.showlogin')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        return $next($request);
    }
}
