<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Digital Nomad',
            'email' => 'nomaddeveloper@mydigitalnomads.co.uk',
            'password' => bcrypt('secret'),
        ]);

        $this->addCustomToken($user);

        $user->events()->saveMany(Event::factory()->count(5)->make())
            ->skip(1)
            ->each(function (Event $event) use ($user) {
                $this->addReviewForEvent($event, $user);
                $this->addReservationForEvent($event, $user);
            });
    }

    private function addReviewForEvent(Event $event, User $user): void
    {
        $event->reviews()->save(
            Review::factory()->make(['user_id' => $user->id])
        );
    }

    private function addReservationForEvent(Event $event, User $user): void
    {
        $user->reservations()->save(
            Reservation::factory()->make(['event_id' => $event->id])
        );
    }

    protected function addCustomToken(User $user): void
    {
        $user->createToken('Seeded Token for Postman');
        $token = $user->tokens()->first();
        $token->token = 'e080760ea94879687925969f09899e0c35fc214038dfa1c058bc8a13ba61c89e';
        $token->save();
    }
}
