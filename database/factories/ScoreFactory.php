<?php

namespace Database\Factories;

use App\Models\Score;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScoreFactory extends Factory
{
    protected $model = Score::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'game_id' => \App\Models\Game::factory(),
            'points' => $this->faker->numberBetween(0, 1000),
            'created_at' => $this->faker->dateTimeThisMonth,
        ];
    }
}
