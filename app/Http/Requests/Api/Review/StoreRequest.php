<?php

namespace App\Http\Requests\Api\Review;

use App\Http\Requests\Api\BaseFormRequest;
use Illuminate\Auth\Access\AuthorizationException;

class StoreRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        if ($this->eventHasUserReview()) {
            throw new AuthorizationException('You have already reviewed this event.');
        }

        if (! $this->userAssistedEvent()) {
            throw new AuthorizationException('You can not review an event that you have not attended.');
        }

        return true;
    }

    public function rules(): array
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ];
    }

    protected function eventHasUserReview()
    {
        return $this->user()->reviews()->where('event_id', $this->route('event')->id)->exists();
    }

    protected function userAssistedEvent()
    {
        return $this->route('event')->reservations()->where('user_id', $this->user()->id)->exists();
    }
}
