<?php

namespace App\Exceptions;

use App\Traits\Api\HandlesApiResponses;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as BaseHandler;

class Handler extends BaseHandler
{
    use HandlesApiResponses;

    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*') || $request->wantsJson()) {
            return $this->respondError(
                message: 'Server Error',
                statusCode: method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500
            );
        }

        return parent::render($request, $exception);
    }
}
