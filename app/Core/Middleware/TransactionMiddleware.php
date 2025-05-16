<?php

namespace App\Core\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TransactionMiddleware
{
    /**
     * @throws Throwable
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isMethod('get')) {
            return $next($request);
        }

        DB::beginTransaction();
        try {
            /** @var JsonResponse $response */
            $response = $next($request);
            if (! ($response instanceof JsonResponse)) {
                DB::commit();

                return $response;
            }

            if ($response->getStatusCode() == 500) {
                DB::rollBack();

                return $response;
            }

            $data = $response->getData(true);
            if (isset($data['status']) && $data['status'] === 'error') {
                DB::rollBack();

                return $response;
            }

            DB::commit();
        } catch (\Exception|Throwable $e) {
            DB::rollBack();
            logger('rollback error');
            throw $e;
        }

        return $response;
    }
}
