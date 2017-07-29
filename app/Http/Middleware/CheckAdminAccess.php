<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminAccess
{
    public function handle($request, Closure $next) {
        if ($request->user()->isAdmin()) {
            return $next($request);
        }

        abort(403, 'Access denied');
    }
}
