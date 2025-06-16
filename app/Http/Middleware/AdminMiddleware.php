<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {

        if (!$request->user() || !$request->user()->is_admin) {

            if ($request->routeIs('login') || $request->routeIs('register')) {
                return $next($request);
            }

            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}
