<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    // Specify which attributes are mass assignable
    protected $fillable = [
        'date',
        'user_id',
        'game_id',
        'points',
        'rank',
        'type'
    ];

    // If you want to use timestamps in the model
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDaily($query, $gameId)
    {
        $today = now()->toDateString();

        return $query->where('type', 'daily')
            ->where('game_id', $gameId)
            ->where('date', $today)
            ->orderBy('points', 'desc');
    }

    public function scopeWeekly($query, $gameId)
    {
        $startOfWeek = now()->startOfWeek()->toDateString();
        $endOfWeek = now()->endOfWeek()->toDateString();

        return $query->where('type', 'weekly')
            ->where('game_id', $gameId)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->orderBy('points', 'desc');
    }
}
