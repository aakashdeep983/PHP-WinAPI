<?php

namespace WinAPI\Types;

use WinAPI\Patterns\Class2Size;
use WinAPI\Patterns\Class2Unsigned;

/**
 * @method int size()
 * @method bool unsigned()
 */
abstract class AbstractNumType extends AbstractType
{
    use Class2Size;
    use Class2Unsigned;

    /**
     * @var int
     */
    protected $value;

    /**
     * @return int
     */
    public function value()
    {
        return (int)$this->value;
    }

}
