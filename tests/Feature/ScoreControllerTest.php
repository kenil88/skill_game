<?php

namespace Tests\Feature;

use App\Jobs\UpdateLeaderboard;
use App\Models\Game;
use App\Models\Score;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ScoreControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_score()
    {
        Queue::fake();

        $user = User::factory()->create();
        $game = Game::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/scores', [
            'game_id' => $game->id,
            'points' => 100,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Score added successfully']);

        $this->assertDatabaseHas('scores', [
            'user_id' => $user->id,
            'game_id' => $game->id,
            'points' => 100,
        ]);

        Queue::assertPushed(UpdateLeaderboard::class);
    }

    public function test_validation_errors()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/scores', [
            'game_id' => null,
            'points' => -10,
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'errors' => [
                    'game_id',
                    'points',
                ],
            ]);
    }
}
