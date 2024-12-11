<?php

namespace App\Http\Requests\Api;

use App\Traits\Api\HandlesApiResponses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class BaseFormRequest extends FormRequest
{
    use HandlesApiResponses;

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->respondError(
            'Validation failed',
            $validator->errors(),
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY
        ));
    }
}
