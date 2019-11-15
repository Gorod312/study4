<?php


namespace app\traits;


trait Tsingletone
{
    private static $instance=null;
    private function __construct()
    {
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    private function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }
    public static function getInstance(){
        if (static::$instance===null){
            static::$instance= new static();
        }
        return self::$instance;
    }

}