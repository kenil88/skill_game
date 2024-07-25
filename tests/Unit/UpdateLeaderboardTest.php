<?php

namespace Tests\Unit;

use App\Jobs\UpdateLeaderboard;
use App\Jobs\UpdateLeaderboardRank;
use App\Models\Score;
use App\Models\Leaderboard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UpdateLeaderboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_daily_leaderboard()
    {
        Queue::fake();

        $score = Score::factory()->create();

        $job = new UpdateLeaderboard($score);
        $job->handle();

        $this->assertDatabaseHas('leaderboards', [
            'type' => 'daily',
            'game_id' => $score->game_id,
            'user_id' => $score->user_id,
            'points' => $score->points,
        ]);

        Queue::assertPushed(UpdateLeaderboardRank::class);
    }

    public function test_it_updates_weekly_leaderboard()
    {
        Queue::fake();

        $score = Score::factory()->create();

        $job = new UpdateLeaderboard($score);
        $job->handle();

        $this->assertDatabaseHas('leaderboards', [
            'type' => 'weekly',
            'game_id' => $score->game_id,
            'user_id' => $score->user_id,
            'points' => $score->points,
        ]);

        Queue::assertPushed(UpdateLeaderboardRank::class);
    }
}
