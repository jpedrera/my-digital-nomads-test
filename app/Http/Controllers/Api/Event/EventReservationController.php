<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\Reservation\StoreRequest;

class EventReservationController extends BaseController
{
    public function store(StoreRequest $request)
    {
        $event = $request->user()->events()->create($request->validated());

        return $this->respondSuccess(
            ['event_id' => $event->id],
            'Event created successfully',
            JsonResponse::HTTP_CREATED
        );
    }
}
