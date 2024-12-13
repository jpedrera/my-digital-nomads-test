<?php

namespace App\Exceptions;

use App\Traits\Api\HandlesApiResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as BaseHandler;

class Handler extends BaseHandler
{
    use HandlesApiResponses;

    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*') || $request->wantsJson()) {
            if ($exception instanceof AuthenticationException) {
                return $this->respondError(
                    message: 'Unauthenticated',
                    statusCode: JsonResponse::HTTP_UNAUTHORIZED
                );
            }

            if ($exception instanceof AuthorizationException) {
                return $this->respondError(
                    message: $exception->getMessage(),
                    statusCode: JsonResponse::HTTP_FORBIDDEN
                );
            }

            if ($exception instanceof ModelNotFoundException) {
                return $this->respondError(
                    message: 'Resource not found',
                    statusCode: JsonResponse::HTTP_NOT_FOUND
                );
            }

            return $this->respondError(
                statusCode: method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500
            );
        }

        return parent::render($request, $exception);
    }
}
