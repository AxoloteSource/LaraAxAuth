<?php

namespace App\Kernel\Middleware;

use App\Kernel\Enums\RoleIdEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAllow
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $action): Response
    {
        if ($request->user()->role_id != RoleIdEnum::Root->value && ! $request->user()->role->actions()->where('name', $action)->exists()) {
            abort(403, __('You do not have permission to access this resource'));
        }

        return $next($request);
    }
}
