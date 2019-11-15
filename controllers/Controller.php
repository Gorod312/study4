<?php

namespace app\controllers;

use app\interfaces\IRender;

abstract class Controller implements IRender
{
    protected $default='main';
    protected $action;
    protected $renderer;

    /**
     * Controller constructor.
     * @param $render
     */
    public function __construct(IRender $render)
    {
        $this->renderer = $render;
    }
    public function runAction($action=null)
    {
        $this->action=$action ?: $this->default;
        $method=$this->action."Action";
        if (method_exists($this, $method))
        {
            $this->$method();
        } else{
            $this->mainAction();
        }
    }
    public function renderTemplate($template, $param = [])
    {
        return $this->renderer->renderTemplate($template,$param);
    }

}