<?php

namespace WinAPI\Patterns;

trait Class2Size
{
    /**
     * @return int
     */
    public function size()
    {
        return (int)(preg_replace('/.+(\d+)\w+/', '${1}', get_called_class())/4);
    }

}
