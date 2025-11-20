<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $me = me('admin');

        if ($me == null) {
            return redirect()->route('admin.login')->withErrors([
                'Login dahulu sebelum melanjutkan'
            ]);
        }
        return $next($request);
    }
}
