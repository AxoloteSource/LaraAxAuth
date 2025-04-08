<?php

namespace App\Core\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAllow
{
    public function handle(Request $request, Closure $next, string $action): Response
    {
        if (! $request->user()->belongsToAction($action)) {
            abort(403, __('You do not have permission to access this resource'));
        }

        return $next($request);
    }
}
