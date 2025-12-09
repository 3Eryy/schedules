<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FilamentAdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (! $user || $user->role !== 'admin') {
            abort(403, 'Anda tidak punya akses ke halaman admin.');
        }

        return $next($request);
    }
}
