<?php

namespace App\Jobs;

use App\Models\Score;
use App\Models\Leaderboard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateLeaderboard implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $score;

    /**
     * Create a new job instance.
     */
    public function __construct(Score $score)
    {
        $this->score = $score;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $score = $this->score;

        // Update daily leaderboard
        $date = $score->created_at->toDateString();
        $this->updateLeaderboard('daily', $score, $date);

        // Update weekly leaderboard
        $startOfWeek = $score->created_at->startOfWeek()->toDateString();
        $this->updateLeaderboard('weekly', $score, $startOfWeek);
    }

    protected function updateLeaderboard($type, $score, $date)
    {
        $leaderboard = Leaderboard::where('type', $type)
            ->where('game_id', $score->game_id)
            ->where('user_id', $score->user_id)
            ->where('date', $date)
            ->first();

        if ($leaderboard) {
            $leaderboard->points += $score->points;
            $leaderboard->save();
        } else {
            Leaderboard::create([
                'type' => $type,
                'game_id' => $score->game_id,
                'date' => $date,
                'user_id' => $score->user_id,
                'points' => $score->points,
            ]);
        }

        // Dispatch rank update job
        UpdateLeaderboardRank::dispatch($score->game_id, $type);
    }
}
