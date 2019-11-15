<?php

namespace app\controllers;


class MainController extends Controller
{
    public function mainAction()
    {

        $template = 'mainpage';
        $render = $this->renderTemplate($template);
        var_dump($render);
    }

}