<?php

namespace App\Controllers;

use App\Routers\RouteParams;
use App\Services\MovieService;
use App\Views\View;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MovieController extends Controller
{
    /**
     * @var MovieService
     */
    protected $movieService;

    /**
     * MovieController constructor.
     */
    public function __construct()
    {
        $this->movieService = MovieService::getInstance();
    }

    /**
     * @param RouteParams $routeParams
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(RouteParams $routeParams)
    {
        $categories = $this->movieService->getMovies($routeParams->getQuery());

        return View::getInstance()->render('index.html.twig', ['categories' => $categories]);
    }
}