<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return Arr::except(parent::toArray($request), ['created_at', 'updated_at']);
    }
}
