<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Booth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $me = me('booth');

        if ($me == null) {
            return redirect()->route('booth.login')->withErrors([
                'Login dahulu sebelum melanjutkan'
            ]);
        }
        return $next($request);
    }
}
