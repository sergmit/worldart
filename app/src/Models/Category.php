<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @method static find(int $int)
 * @method static create(string[] $array)
 * @property string link
 */
class Category extends Model
{
    protected $table = 'category';
    protected $fillable = ['title', 'link'];
    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class, 'category_id');
    }

    /**
     * @return HasManyThrough
     */
    public function ratingMovies(): HasManyThrough
    {
        return $this->hasManyThrough(RatingMovie::class, Movie::class, 'category_id', 'movie_id')
            ->where('position', '<', 11);
    }
}