<?php

namespace WinAPI\Types;


/**
 * @method static Int8UType Int8U()
 * @method static Int8Type Int8()
 * @method static Int16UType Int16U()
 * @method static Int16Type Int16()
 * @method static Int32UType Int32U()
 * @method static Int32Type Int32()
 * @method static Float32Type Float32()
 * @method static Float64Type Float64()
 */
class TypeFactory
{
    const TYPE     = 1;
    const SIZE     = 2;
    const UNSIGNED = 3;

    /**
     * @param $method
     * @param $arguments
     *
     * @return object
     */
    public static function __callStatic($method, $arguments)
    {
        $class = sprintf('WinAPI\\Types\\%sType',$method);
        if (class_exists($class)) {
            return new $class($arguments);
        }
    }

}
