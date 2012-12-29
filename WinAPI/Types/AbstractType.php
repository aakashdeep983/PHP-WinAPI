<?php

namespace WinAPI\Types;

abstract class AbstractType
{
    /**
     * @var string
     */
    protected $alias;

    /**
     * @return int
     */
    abstract public function size();

    /**
     * @return mixed
     */
    abstract public function value();

    /**
     * @return string
     */
    public function alias()
    {
        return $this->alias;
    }
}
