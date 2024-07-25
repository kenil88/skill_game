<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function getDailyRank(Request $request, $gameId)
    {
        $dailyLeaderboard = Leaderboard::daily($gameId)->get();

        $rankedLeaderboard = $dailyLeaderboard->map(function ($item, $index) {
            return [
                'rank' => $index + 1,
                'user_id' => $item->user_id,
                'points' => $item->points,
            ];
        });

        return response()->json($rankedLeaderboard);
    }

    public function getWeeklyRank(Request $request, $gameId)
    {
        $weeklyLeaderboard = Leaderboard::weekly($gameId)->get();

        $rankedLeaderboard = $weeklyLeaderboard->map(function ($item, $index) {
            return [
                'rank' => $index + 1,
                'user_id' => $item->user_id,
                'points' => $item->points,
            ];
        });

        return response()->json($rankedLeaderboard);
    }
}
