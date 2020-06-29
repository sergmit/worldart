<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(int $int)
 * @property int position
 * @property int score
 * @property int voices
 * @property float averageScore
 * @property false|mixed|string created
 */
class RatingMovie extends Model
{
    protected $table = 'ratingMovie';
    protected $fillable = ['position', 'score', 'voices', 'averageScore', 'created'];
    public $timestamps = false;

    protected $dates = ['created'];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }
}