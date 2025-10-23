<?php

namespace App\Core\Middleware;

use App\Core\Enums\Http;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class ValidateSignatureExceptPagination
{
    protected $ignoreParameters = [
        'page',
        'limit',
    ];

    public function handle(Request $request, Closure $next)
    {
        $providedSignature = $request->query('signature');

        if (empty($providedSignature)) {
            return $this->errorResponse(__('Page not found'));
        }

        $expirationResult = $this->checkExpiration($request);
        if ($expirationResult['is_expired']) {
            return $this->errorResponse('Invalid signature', $expirationResult, Http::Forbidden);
        }

        $isValidSignature = $this->isValidSignature($request, $providedSignature);
        if (! $isValidSignature) {
            if ($request->has('expires')) {
                $message = 'La firma de la URL es inválida (posiblemente manipulada).';
            } else {
                $message = 'La firma de la URL es inválida.';
            }

            return $this->errorResponse('Invalid signature', ['message' => $message], Http::Forbidden);
        }

        return $next($request);
    }

    protected function checkExpiration(Request $request): array|bool
    {
        $hasExpired = false;

        if ($request->has('expires')) {
            $expiresTimestamp = (int) $request->query('expires');
            $expirationDate = Carbon::createFromTimestamp($expiresTimestamp);
            $hasExpired = now()->timestamp > $expiresTimestamp;

            return [
                'expired_at' => $expirationDate->toISOString(),
                'current_time' => now()->toISOString(),
                'expired_since' => now()->diffForHumans($expirationDate),
                'is_expired' => $hasExpired,
            ];
        }

        return ['is_expired' => $hasExpired];
    }

    protected function isValidSignature(Request $request, string $providedSignature): bool
    {
        $relevantParams = $this->getRelevantParameters($request);
        $urlToVerify = $this->buildUrlToVerify($request, $relevantParams);
        $expectedSignature = hash_hmac('sha256', $urlToVerify, config('app.key'));

        return hash_equals($expectedSignature, $providedSignature);
    }

    protected function getRelevantParameters(Request $request): array
    {
        $relevantParams = collect($request->query())
            ->except(array_merge($this->ignoreParameters, ['signature']))
            ->toArray();

        ksort($relevantParams);

        return $relevantParams;
    }

    protected function buildUrlToVerify(Request $request, array $relevantParams): string
    {
        $urlToVerify = $request->url();

        if (! empty($relevantParams)) {
            $urlToVerify .= '?'.http_build_query($relevantParams);
        }

        return $urlToVerify;
    }

    protected function errorResponse(string $message, $data = null, Http $status = Http::NotFound)
    {
        return response()->error(
            __($message),
            $data,
            $status
        );
    }
}
