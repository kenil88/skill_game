<?php

namespace Tests\Unit;

use App\Jobs\UpdateLeaderboardRank;
use App\Models\Leaderboard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateLeaderboardRankTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_ranks_correctly()
    {
        $gameId = 1;
        $type = 'daily';

        Leaderboard::factory()->create(['game_id' => $gameId, 'type' => $type, 'points' => 100, 'rank' => 1]);
        Leaderboard::factory()->create(['game_id' => $gameId, 'type' => $type, 'points' => 200, 'rank' => 2]);
        Leaderboard::factory()->create(['game_id' => $gameId, 'type' => $type, 'points' => 150, 'rank' => 3]);

        $job = new UpdateLeaderboardRank($gameId, $type);
        $job->handle();

        $this->assertDatabaseHas('leaderboards', ['game_id' => $gameId, 'type' => $type, 'points' => 200, 'rank' => 1]);
        $this->assertDatabaseHas('leaderboards', ['game_id' => $gameId, 'type' => $type, 'points' => 150, 'rank' => 2]);
        $this->assertDatabaseHas('leaderboards', ['game_id' => $gameId, 'type' => $type, 'points' => 100, 'rank' => 3]);
    }
}
