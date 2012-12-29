<?php

namespace WinAPI\Types;

abstract class AbstractStructure extends AbstractType implements \Iterator, \ArrayAccess
{
    /**
     * @var AbstractType[]
     */
    protected $array;
    protected $keyValue;
    protected $keyPosition = 0;

    /**
     * @return AbstractType
     */
    public function current()
    {
        return $this->value[$this->key()];
    }

    /**
     * @return AbstractStructure
     */
    public function next()
    {
        $this->keyPosition++;
        return $this;
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return $this->keys()[$this->keyPosition];
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->keys()[$this->keyPosition]);
    }

    /**
     * @return AbstractStructure
     */
    public function rewind()
    {
        $this->keyPosition = 0;
        return $this;
    }

    /**
     * @return array
     */
    public function keys()
    {
        return array_keys($this->array);
    }

    /**
     * @return AbstractType[]
     */
    public function values()
    {
        return array_values($this->array);
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->array[$offset]);
    }

    /**
     * @param mixed $offset
     *
     * @return AbstractType
     */
    public function offsetGet($offset)
    {
        return $this->array[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     *
     * @return AbstractStructure
     */
    public function offsetSet($offset, $value)
    {
        $this->array[$offset] = $value;
        return $this;
    }

    /**
     * @param mixed $offset
     *
     * @return AbstractStructure
     */
    public function offsetUnset($offset)
    {
        unset($this->array[$offset]);
        return $this;
    }

    /**
     * @param $offset
     *
     * @return AbstractStructure
     */
    public function offsetDelete($offset)
    {
        array_splice($this->array, $offset, 1);
        return $this;
    }

    /**
     * @param $offset
     * @param $value
     *
     * @return AbstractStructure
     */
    public function offsetInsert($offset, $value)
    {
        array_splice($this->array, $offset, 0, $value);
        return $this;
    }

    /**
     * @return int
     */
    public function size()
    {
        return count($this->array);
    }

}
