<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static find(int $int)
 * @method static findByArtId(int $movieArtId)
 * @method static firstWhere(string $string, string|null $movieArtId)
 * @property string name
 * @property int artId
 * @property string description
 * @property string image
 * @property int year
 */
class Movie extends Model
{
    protected $table = 'movie';
    protected $fillable = ['name', 'description', 'year', 'image', 'artMovieId'];
    public $timestamps = false;

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}