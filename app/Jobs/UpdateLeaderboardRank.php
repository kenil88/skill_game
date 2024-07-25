<?php

namespace App\Jobs;

use App\Models\Leaderboard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateLeaderboardRank implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $gameId;
    protected $type; // Added type to differentiate between daily and weekly leaderboards

    public function __construct($gameId)
    {
        $this->gameId = $gameId;
    }

    public function handle()
    {
        try {
            $leaderboards = Leaderboard::where('game_id', $this->gameId)
                ->orderBy('points', 'desc') // Sort by points, adjust if needed
                ->orderBy('created_at', 'asc') // Optional: to handle ties
                ->get();

            foreach ($leaderboards as $index => $leaderboard) {
                $leaderboard->update(['rank' => $index + 1]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to update leaderboard ranks: ' . $e->getMessage());
        }
    }
}
