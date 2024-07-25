<?php

namespace Database\Factories;

use App\Models\Leaderboard;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaderboardFactory extends Factory
{
    protected $model = Leaderboard::class;

    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['daily', 'weekly']),
            'game_id' => \App\Models\Game::factory(),
            'user_id' => \App\Models\User::factory(),
            'points' => $this->faker->numberBetween(0, 1000),
            'date' => $this->faker->date(),
            'rank' => null,
        ];
    }
}
