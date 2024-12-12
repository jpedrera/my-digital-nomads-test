<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\Review\StoreRequest as ReviewStoreRequest;
use App\Http\Resources\EventReviewResource;
use App\Models\Event;
use App\Repositories\ReviewRepositoryInterface;
use Illuminate\Http\JsonResponse;

class EventReviewController extends BaseController
{
    public function __construct(private readonly ReviewRepositoryInterface $reviewRepository)
    {
    }

    public function index(Event $event): JsonResponse
    {
        return $this->respondPagination(
            paginator: $this->reviewRepository->getReviewsFromEvent($event),
            resource: EventReviewResource::class,
            included: ['event' => $event->only('id', 'average_rating')],
        );
    }

    public function store(ReviewStoreRequest $request, Event $event): JsonResponse
    {
        $review = $this->reviewRepository->createReview($event, $request->validated());

        return $this->respondSuccess(
            ['review_id' => $review->id],
            'Review created successfully',
            JsonResponse::HTTP_CREATED
        );
    }
}
