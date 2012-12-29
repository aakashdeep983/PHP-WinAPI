<?php

namespace WinAPI\Types;

abstract class AbstractStringType extends AbstractType
{
    /**
     * @var string
     */
    protected $value='';

    public function size()
    {
        return strlen($this->value);
    }
}
