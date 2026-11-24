<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->guest('/login')->with('error', 'Silakan masuk dengan akun administrator.');
        }

        if (! Auth::user()->isAdmin()) {
            // P4 Checklist: Customer ketik /admin/products ditolak 403
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk mengakses area Seller Center.');
        }

        return $next($request);
    }
}
