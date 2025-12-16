<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN role-nya admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Kalau bukan admin, tendang keluar (403 Forbidden)
        abort(403, 'Akses ditolak. Halaman ini khusus Admin.');
    }
}
