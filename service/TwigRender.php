<?php

namespace app\service;

use app\interfaces\IRender;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRender implements IRender
{

    private $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader([
            dirname(__DIR__) . '/views',
        ]);
        $this->twig = new Environment($loader, []);
    }

    public function renderTemplate($template, $param = [])
    {
        $template .= '.twig';
        $this->twig->render($template, $param);
    }


}