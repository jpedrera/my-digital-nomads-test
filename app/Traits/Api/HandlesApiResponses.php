<?php

namespace App\Traits\Api;

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
