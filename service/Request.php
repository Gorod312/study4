<?php
namespace app\service;


class Request
{
    private $controllerName;
    private $actionName;
    private $param;
    private $requestString;
    private $method;

    /**
     * Request constructor.
     * @param $requestString
     */
    public function __construct()
    {
        $this->requestString = $_SERVER['REQUEST_URI'];
        $this->parseRequestString();
    }
    private function parseRequestString()
    {
        $this->method=$_SERVER['REQUEST_METHOD'];
        $url=explode('/', $this->requestString);
        $this->controllerName=$url[1];
        $this->actionName=$url[2];
        $this->param=$_REQUEST;
    }

    /**
     * @return mixed
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * @return mixed
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * @return mixed
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }


}