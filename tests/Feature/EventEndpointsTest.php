<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Tests\TestCase;

class EventEndpointsTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_events_index_returns_paginated_events(): void
    {
        $this->user->events()->saveMany(Event::factory()->count(15)->make());

        $response = $this->actingAs($this->user, 'sanctum')->getJson(route('events.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'items' => [
                        '*' => [
                            'id', 'user_id', 'title', 'description', 'date_time', 'location', 'price', 'attendee_limit',
                        ]
                    ],
                    'pagination' => [
                        'current_page', 'per_page', 'total', 'last_page'
                    ]
                ]
            ]);

        $this->assertCount(15, $response->json('data.items'));
    }

    public function test_events_store_creates_event()
    {
        $eventData = [
            'title' => 'Sample Event',
            'date_time' => now()->addDays(30)->toDateTimeString(),
            'attendee_limit' => 100,
            'description' => 'This is a sample event',
            'location' => 'Worldwide'
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson(route('events.store'), $eventData);

        $response->assertStatus(201)->assertJson([
            'success' => true,
            'message' => 'Event created successfully',
            'data' => [
                'event_id' => $response->json('data.event_id')
            ]
        ]);

        $this->assertDatabaseHas('events', $eventData);
    }

    public function test_events_store_validation_errors()
{
    $eventData = [
        'date_time' => now()->subDay()->toDateTimeString(), // Date in the past
    ];

    $response = $this->actingAs($this->user, 'sanctum')->postJson(route('events.store'), $eventData);

    $response->assertStatus(422)
        ->assertJson([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => [
                'title' => ['The title field is required.'],
                'description' => ['The description field is required.'],
                'date_time' => ['The date time field must be a date after now.'],
                'location' => ['The location field is required.'],
                'attendee_limit' => ['The attendee limit field is required.'],
            ]
        ]);
    }
}
