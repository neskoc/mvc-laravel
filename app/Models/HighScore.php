<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HighScore extends Model
{
    use HasFactory;

    protected $connection = 'sqlite';
    protected $table = 'high_score';
    protected $primaryKey = 'player_id';
    /**
     * Indicates if the model's ID is auto-incrementing.
    */
    public $incrementing = true;
    /**
     * Indicates if the model should be timestamped.
     * created_at and updated_at column must be present
    */
    public $timestamps = true;

    protected $player_name;
    protected $score;

    public function getHighScoreList()
    {
        $data = [
            "header" => "Top 10 all time scores",
            "highScore" => $this::orderByDesc('score')->limit(10)->get(),
            "histogram" => $this::select('score', $this::raw('count(*) as freq'))->groupBy('score')->get()
        ];

        return view("high-score", $data);
    }

    public function savePlayerScore(string $name, int $score)
    {
        $this->player_name = $name;
        $this->score = $score;
        $this->save();
    }
}
