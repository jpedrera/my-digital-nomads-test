<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\Review;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function createReview(Event $event, array $data): Review
    {
        return $event->reviews()->create($data);
    }

    public function getReviewsFromEvent(Event $event): LengthAwarePaginator
    {
        return $event->reviews()->paginate();
    }
}
