<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\Event\StoreRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;

class EventController extends BaseController
{
    public function index(): JsonResponse
    {
        return $this->respondPagination(Event::paginate(), EventResource::class);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $event = $request->user()->events()->create($request->validated());

        return $this->respondSuccess(
            ['event_id' => $event->id],
            'Event created successfully',
            JsonResponse::HTTP_CREATED
        );
    }
}
