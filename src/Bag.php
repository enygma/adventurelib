<?php

namespace Adventurelib;

class Bag implements \Countable, \ArrayAccess, \Iterator
{
    protected $items = [];
    protected $position = 0;

    public function add($item)
    {
        $this->items[] = $item;
    }

    public function find($name, $take = false)
    {
        foreach ($this->items as $index => $item) {
            if ($item->getName() == $name) {
                if ($take == true) {
                    unset($this->items[$index]);
                }
                return $item;
            }
        }
        return null;
    }

    public function take($name)
    {
        return $this->find($name, true);
    }

    public function count()
    {
        return count($this->items);
    }

    public function offsetSet($offset, $item)
    {
        $this->items[$offset] = $item;
    }
    public function offsetGet($offset)
    {
        return (isset($this->items[$offset])) ? $this->items[$offset] : null;
    }
    public function offsetExists($offset)
    {
        return (isset($this->items[$offset]));
    }
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset) == true) {
            unset($this->items[$offset]);
        }
    }

    public function current()
    {
        return $this->items[$this->position];
    }
    public function key()
    {
        return $this->position;
    }
    public function rewind()
    {
        $this->position = 0;
    }
    public function next()
    {
        ++$this->position;
    }
    public function valid()
    {
        return (isset($this->items[$this->position]));
    }
}