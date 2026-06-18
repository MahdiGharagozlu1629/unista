<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClientAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        return $request->expectsJson() ? null : route('clinetLogin');
    }
}
