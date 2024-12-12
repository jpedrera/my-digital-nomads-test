<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'date_time' => $this->faker->dateTimeBetween('+1 day', '+1 year'),
            'location' => $this->faker->address,
            'price' => $this->faker->randomFloat(2, 0, 100),
            'attendee_limit' => $this->faker->numberBetween(10, 500),
            'created_at' => $this->faker->dateTimeThisYear,
            'updated_at' => $this->faker->dateTimeThisYear,
        ];
    }
}
