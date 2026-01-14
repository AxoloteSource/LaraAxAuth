<?php

namespace App\Core\Middleware;

use App\Core\Enums\Http;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class IsAllow
{
    public function handle(Request $request, Closure $next, string $action)
    {
        if (! $request->user()->belongsToAction($action)) {
            return Response::error(
                message: __('You do not have permission to access this resource'),
                data: ['action' => $action],
                status: Http::Forbidden
            );
        }

        return $next($request);
    }
}
