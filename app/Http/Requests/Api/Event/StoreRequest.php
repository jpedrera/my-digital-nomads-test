<?php

namespace App\Http\Requests\Api\Event;

use App\Http\Requests\Api\BaseFormRequest;

class StoreRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date_time' => 'required|date|after:now',
            'location' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'attendee_limit' => 'required|integer|min:1|max:100',
        ];
    }
}
