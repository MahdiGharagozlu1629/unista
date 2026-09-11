<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientAuthenticate
{
    public function handle(Request $request, Closure $next): \Illuminate\Http\RedirectResponse
    {
        if (!Auth::guard('client')->check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
