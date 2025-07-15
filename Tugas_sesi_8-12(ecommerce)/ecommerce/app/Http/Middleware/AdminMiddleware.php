<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('/login'); // Arahkan ke halaman login jika belum login
            // Atau Anda bisa abort(401) jika ingin langsung UNAUTHORIZED
        }

        // 2. Cek apakah role pengguna BUKAN 'admin'
        if (Auth::user()->role !== 'admin') {
            return abort(403, 'Anda tidak memiliki akses admin.'); // Tampilkan error 403 (Forbidden)
        }

        // 3. Jika sudah login dan role-nya 'admin', lanjutkan request
        return $next($request);
    }
}
