<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $game = Game::create([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Game added successfully', 'game' => $game], 201);
    }
}
