<?php

namespace WinAPI\Patterns;

trait Class2Unsigned
{
    public function unsigned()
    {
        return preg_replace('/.+\d+(U)?\w+/', '${1}', get_called_class())=='U';
    }
}
