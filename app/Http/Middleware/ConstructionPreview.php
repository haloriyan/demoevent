<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConstructionPreview
{
	public function handle(Request $request, Closure $next): Response
	{
		$cookieName = 'construction_preview';

		// Allowed query keys
		$allowedKeys = ['admin', 'prev', 'preview'];

		// 1. Check if any allowed query param exists (key only)
		foreach ($allowedKeys as $key) {
			if ($request->has($key)) {
				return redirect(
					$request->url()
				)->withCookie(
					cookie(
						$cookieName,
						true,
						60 * 24 * 7 // 7 days
					)
				);
			}
		}

		// 2. Allow access if cookie exists
		if ($request->cookie($cookieName)) {
			return $next($request);
		}

		// 3. Otherwise show under construction page
		return response()
			->view('under_construction', [], 503);
	}
}
