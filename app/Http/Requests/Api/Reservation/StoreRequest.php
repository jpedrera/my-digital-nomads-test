<?php

namespace App\Http\Requests\Api\Reservation;

use App\Http\Requests\Api\BaseFormRequest;
use App\Rules\SufficientTicketsAvailable;

class StoreRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $event = $this->route('event');
        return [
            'quantity' => [
                'required',
                'integer',
                'min:1',
                new SufficientTicketsAvailable($event),
            ],
            function ($attribute, $value, $fail) use ($event) {
                if ($event->hasReservationsClosed()) {
                    $fail('Reservations are closed for this event.');
                }
            },
        ];
    }
}
