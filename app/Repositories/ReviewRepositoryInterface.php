<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\Review;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReviewRepositoryInterface
{
    public function createReview(Event $event, array $data): Review;

    public function getReviewsFromEvent(Event $event): LengthAwarePaginator;
}
