<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    // Specify which attributes are mass assignable
    protected $fillable = [
        'user_id',
        'game_id',
        'points'
    ];

    // If you want to use timestamps in the model
    public $timestamps = true;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
