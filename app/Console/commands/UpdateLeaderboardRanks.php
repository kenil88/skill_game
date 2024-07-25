<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Leaderboard;

class UpdateLeaderboardRanks extends Command
{
    protected $signature = 'leaderboards:update-ranks';
    protected $description = 'Update ranks for all leaderboards';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $leaderboards = Leaderboard::all()->groupBy('id');

        foreach ($leaderboards as $leaderboardGroup) {
            foreach ($leaderboardGroup as $index => $leaderboard) {
                $leaderboard->update(['rank' => $index + 1]);
            }
        }

        $this->info('Leaderboards ranks updated successfully!');
    }
}
