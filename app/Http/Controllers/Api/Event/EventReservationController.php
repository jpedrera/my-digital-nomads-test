<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\Reservation\StoreRequest;
use App\Models\Event;
use Illuminate\Http\JsonResponse;

class EventReservationController extends BaseController
{
    public function store(StoreRequest $request, Event $event): JsonResponse
    {
        $event = $request->user()->reservations()->create(
            array_merge($request->validated(), ['event_id' => $event->id])
        );

        return $this->respondSuccess(
            ['event_id' => $event->id],
            'Event created successfully',
            JsonResponse::HTTP_CREATED
        );
    }
}
