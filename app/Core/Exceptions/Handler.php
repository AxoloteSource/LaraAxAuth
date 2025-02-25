<?php

namespace App\Core\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler
{
    public function render(Request $request, Throwable $e)
    {
        if ($request->expectsJson() || $request->ajax() || $request->json()) {
            return match (true) {
                $e instanceof AuthenticationException => response()->json([
                    'message' => 'Unauthenticated.',
                ], 401),
                $e instanceof NotFoundHttpException => response()->notFound(),
                $e instanceof ValidationException => response()->invalidFormRequest($e->errors()),
                $e instanceof HttpException => response()->json(
                    [
                        'message' => $e->getMessage() ?: 'Internal server error.',
                    ],
                    $e->getStatusCode()
                ),
                default => response()->serverError('Server error'),
            };
        }

        return response('An error occurred', 500);
    }
}
