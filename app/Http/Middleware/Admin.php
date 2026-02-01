<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
        $route = Route::currentRouteName();
        $routes = explode(".", $route);

        if ($me == null) {
            return redirect()->route('admin.login')->withErrors([
                'Login dahulu sebelum melanjutkan'
            ]);
        }

        if ($me->role == "frontliner" && !in_array('fo', $routes)) {
            return redirect()->route('fo.home');
        }
        return $next($request);
    }
}
