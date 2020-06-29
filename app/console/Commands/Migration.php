<?php

namespace Console\Commands;

use App\Models\Category;
use Console\BaseCommand;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

class Migration extends BaseCommand
{

    /**
     * @param array|null $args
     */
    public function execute(array $args = null)
    {
        try {
            Manager::schema()->create('category', function(Blueprint $table) {
                $table->increments('id');
                $table->string('title', 150);
                $table->string('link', 255);
            });

            Manager::schema()->create('movie', function(Blueprint $table) {
                $table->increments('id');
                $table->string('name', 150);
                $table->text('description');
                $table->smallInteger('year');
                $table->integer('artId');
                $table->unsignedInteger('category_id');
                $table->string('image', 255);
                $table->index('name');
                $table->index('year');
                $table->index('artId');
                $table->foreign('category_id')->references('id')->on('category');
            });

            Manager::schema()->create('ratingMovie', function(Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('movie_id');
                $table->smallInteger('position');
                $table->smallInteger('score');
                $table->smallInteger('voices');
                $table->decimal('averageScore');
                $table->date('created');
                $table->index('score');
                $table->index('voices');
                $table->index('averageScore');
                $table->foreign('movie_id')->references('id')->on('movie');
            });
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }

        $category = Category::create(['title' => 'Полнометражных фильмы',
            'link' => 'http://www.world-art.ru/cinema/rating_top.php']);
        $category = Category::create(['title' => 'Западные сериалы',
            'link' => 'http://www.world-art.ru/cinema/rating_tv_top.php?public_list_anchor=1']);
        $category = Category::create(['title' => 'Японских дорамы',
            'link' => 'http://www.world-art.ru/cinema/rating_tv_top.php?public_list_anchor=2']);
        $category = Category::create(['title' => 'Корейские дорамы',
            'link' => 'http://www.world-art.ru/cinema/rating_tv_top.php?public_list_anchor=4']);
        $category = Category::create(['title' => 'Российские сериалы',
            'link' => 'http://www.world-art.ru/cinema/rating_tv_top.php?public_list_anchor=3']);
    }
}