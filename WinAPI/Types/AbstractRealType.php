<?php

namespace WinAPI\Types;

use WinAPI\Patterns\Class2Size;

abstract class AbstractRealType extends AbstractType
{
    use Class2Size;

    /**
     * @var float
     */
    protected $value;

    /**
     * @return float
     */
    public function value()
    {
        return (float)$this->value;
    }
}
