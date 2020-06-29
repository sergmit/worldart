<?php

namespace Console\Commands;

use App\Helpers\StringHelper;
use App\Models\Category;
use App\Models\Movie;
use App\Models\RatingMovie;
use App\Services\HtmlParser;
use Console\BaseCommand;
use ReflectionException;

class Parse extends BaseCommand
{
    /**
     * @var HtmlParser
     */
    protected $htmlParser;

    public function __construct()
    {
        $this->htmlParser = new HtmlParser();
    }

    /**
     * @param array|null $args
     */
    public function execute(array $args = null)
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            /** @var Category $category */
            $movies = $this->htmlParser->getListMovie($category->link);

            foreach ($movies as $item) {
                $movieRoute = StringHelper::parseUri($item['link']);
                $movieArtId = $movieRoute->getQuery()->get('id');
                /** @var Movie $movie */
                $movie = Movie::firstWhere('artId', $movieArtId);

                if (empty($movie)) {
                    $dataMovie = $this->htmlParser->getMovie($item['link'], $movieArtId);
                    $movie = new Movie();
                    $movie->name = $item['title'];
                    $movie->artId = $movieArtId;
                    $movie->description = $dataMovie['description'];
                    $movie->image = $dataMovie['img'];
                    $movie->year = $item['year'];
                    $movie->category()->associate($category);
                    $movie->save();
                }

                $ratingMovie = new RatingMovie();
                $ratingMovie->position = $item['position'];
                $ratingMovie->score = $item['score'];
                $ratingMovie->voices = $item['voices'];
                $ratingMovie->averageScore = $item['averageScore'];
                $ratingMovie->created = date('Y-m-d');
                $ratingMovie->movie()->associate($movie);
                $ratingMovie->save();
            }
        }

    }
}

;