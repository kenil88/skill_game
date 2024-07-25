<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    // Specify which attributes are mass assignable
    protected $fillable = [
        'name',
        'description',
    ];

    // If you want to use timestamps in the model
    public $timestamps = true;

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
