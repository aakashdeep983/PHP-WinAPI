<?php

namespace WinAPI\Patterns;

trait SingletonTrait
{
    /**
     * @var static
     */
    protected static $instance;

    /**
     * @var static
     */
    public static  function getInstance()
    {
        if (!static::$instance instanceof static) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    protected function __construct(){}
    protected function __clone(){}
    protected function __sleep(){}
    protected function __wakeup(){}

}
