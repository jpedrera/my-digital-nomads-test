<?php

namespace App\Http\Requests\Api;

class LoginRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ];
    }
}
