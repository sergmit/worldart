<?php

namespace App\Views;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class View
{
    /**
     * @var View
     */
    protected static $instance;

    /**
     * @var Environment
     */
    protected $twig;

    /**
     * View constructor.
     */
    protected function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . "/templates");
        $this->twig = new Environment($loader, ['cache' => __DIR__ . "/cache", 'debug' => true]);
        $this->twig->addExtension(new DebugExtension());
    }

    /**
     * @return View
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new View();
        }

        return self::$instance;
    }

    /**
     * @return Environment
     */
    public function getTwig(): Environment
    {
        return $this->twig;
    }

    /**
     * @param string $template
     * @param array $data
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $template, array $data = []): string
    {
        return $this->twig->render($template, $data);
    }
}