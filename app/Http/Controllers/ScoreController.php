<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateLeaderboard;
use App\Jobs\UpdateLeaderboardRank;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ScoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'game_id' => 'required|integer|exists:games,id', // Ensure game_id exists in games table
            'points' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Use a database transaction to ensure data integrity
        DB::beginTransaction();

        try {
            $user = Auth::user();

            // Create the score record
            $score = Score::create([
                'user_id' => $user->id,
                'game_id' => $request->game_id,
                'points' => $request->points,
            ]);

            // Dispatch the jobs
            UpdateLeaderboard::dispatch($score);


            // Commit the transaction
            DB::commit();

            return response()->json(['message' => 'Score added successfully']);
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Log the exception and return an error response
            Log::error('Error adding score: ' . $e->getMessage());

            return response()->json(['error' => 'An error occurred while adding the score'], 500);
        }
    }
}
