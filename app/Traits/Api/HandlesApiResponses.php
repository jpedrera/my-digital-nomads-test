<?php

namespace App\Traits\Api;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

trait HandlesApiResponses
{
    public function respondSuccess($data = [], $message = 'Operation successful', $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    public function respondPagination(LengthAwarePaginator $paginator, $resource = null, $message = 'Operation successful', array $included = []): JsonResponse
    {
        $payload = [
            'items' => $resource ? $resource::collection($paginator->items()) : $paginator->items(),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
            ],
        ];

        if (! empty($included)) {
            $payload['included'] = $included;
        }

        return $this->respondSuccess($payload, $message);
    }

    public function respondError($message = 'Internal Server Error', $errors = [], $statusCode = 500): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }

    public function respondInternalError(): JsonResponse
    {
        return $this->respondError();
    }
}
