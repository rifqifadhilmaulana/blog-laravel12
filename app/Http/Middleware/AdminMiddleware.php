<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // PERBAIKAN: Menggunakan isAdmin()
        if (!auth()->check() || !auth()->user()->isAdmin()) { 
            abort(403, 'Akses Ditolak. Anda bukan Admin.');
        }

        return $next($request);
    }
}