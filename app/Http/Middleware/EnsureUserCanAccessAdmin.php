<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserCanAccessAdmin
{
    /**
     * Handle an incoming request.
     * Note: Auth check is handled by the 'auth' middleware in web.php.
     * This middleware only verifies admin panel authorization.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()->canAccessAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke admin panel.');
        }

        return $next($request);
    }
}
