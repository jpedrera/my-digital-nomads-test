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

        ];
    }

    protected function after()
    {
        $event = $this->route('event');
        return [
            function ($validator) use ($event) {
                if ($event->hasReservationsClosed()) {
                    $validator->errors()->add('event', 'Reservations are closed for this event.'
                    );
                }
                if ($event->reservations()->where('user_id', $this->user()->id)->exists()) {
                    $validator->errors()->add('event', 'You have already made a reservation for this event.');
                }
            },
        ];
    }
}
