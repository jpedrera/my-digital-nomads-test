<?php

namespace App\Rules;

use App\Models\Event;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SufficientTicketsAvailable implements ValidationRule
{
    protected Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function validate(string $attribute, mixed $requestedReservations, Closure $fail): void
    {
        $currentReservations = $this->event->reservations()->sum('quantity');
        $totalReservations = $currentReservations + $requestedReservations;

        if ($totalReservations > $this->event->attendee_limit) {
            $fail("Not enough tickets available for the requested quantity ({$requestedReservations}).");
        }
    }
}
