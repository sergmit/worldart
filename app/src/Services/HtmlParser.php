<?php

namespace App\Services;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class HtmlParser extends AbstractHtmlParser
{
    public const COUNT_MOVIES = 10;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @param string $link
     * @return array
     */
    public function getListMovie(string $link)
    {
        $movies = [];
        $crawler = $this->client->request('GET', $link);
        if ($crawler !== null) {
            $crawler->filter('table:nth-child(7) table table:nth-child(4) tr:nth-child(n + 2)')
                ->each(function ($node, $i) use (&$movies, &$counter) {
                    if ($i >= self::COUNT_MOVIES) {
                        return;
                    }

                    $position = $i;
                    $movie = null;
                    $node->filter('td')->each(function ($node, $i) use (&$movies, &$counter, $position, &$movie) {
                        /** @var Crawler $node */

                        if ($i === 1 && $node !== null) {
                            preg_match('/(?P<title>.+) \[(?P<year>\d{4})]/', $node->text(), $matches);
                            $link = $node->filter('a')->link()->getUri();
                            $movie = ['link' => $link, 'title' => $matches['title'], 'year' => $matches['year']];
                        }

                        $movie['position'] = ++$position;

                        if ($i === 2) {
                            $movie['score'] = $node->text();
                        }

                        if ($i === 3) {
                            $movie['voices'] = $node->text();
                        }

                        if ($i === 4) {
                            $movie['averageScore'] = $node->text();
                            $movies[] = $movie;
                            $movie = [];
                        }
                    });

                });
        }

        return $movies;
    }

    /**
     * @param string $link
     * @param int $artId
     * @return array
     */
    public function getMovie(string $link, int $artId): array
    {
        $data = [];
        $url = 'http://www.world-art.ru/cinema/';
        $client = new Client();
        $crawler = $client->request('GET', $link);
        if ($crawler !== null) {
            $img = $crawler->filter('table:nth-child(5) table img')->first()->attr('src');
            $pathImg = $url . $img;
            $extension = pathinfo(parse_url($pathImg, PHP_URL_PATH), PATHINFO_EXTENSION);
            $img = file_get_contents($pathImg);
            $imgPath = __DIR__ . "/../../public/images/$artId." . $extension;
            file_put_contents($imgPath, $img);
            $data['img'] = "/images/$artId.$extension";

            $crawler->filter('table td b:contains("Краткое содержание")')->each(function ($node) use (&$data) {
                $data['description'] = $node->parents()->parents()->parents()->nextAll()->first()->text('');
            });

            if (empty($data['description'])) {
                $data['description'] = '';
            }
        }

        return $data;
    }
}