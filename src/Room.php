<?php

namespace Adventurelib;

class Room
{
    protected $name = '';
    protected $description = '';

    protected $items;
    protected $directions = [
        'north' => 'south',
        'south' => 'north', 
        'east' => 'west', 
        'west' => 'east'
    ];
    protected $exits = [];

    public function __construct($name, $description)
    {
        $this->setName($name);
        $this->setDescription($description);
        $this->items = new Bag();
    }

    public function __get($name)
    {
        if (property_exists($this, $name) == true) {
            return $this->$name;
        }
        return null;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function addItem(\Adventurelib\Item $item)
    {
        $this->items->add($item);
    }

    public function getExits()
    {
        return $this->exits;
    }

    public function hasExit($direction)
    {
        return (isset($this->exits[$direction]));
    }

    public function addExit($direction, \Adventurelib\Room &$room)
    {
        $this->exits[$direction] = $room;

        // Now add an exit the other direction, if not exists
        $opposite = $this->directions[$direction];
        if (!$room->hasExit($opposite)) {
            $room->addExit($opposite, $this);
        }
    }

    public function getItems()
    {
        return $this->items;
    }

    public function has($itemName)
    {
        return $this->items->find($itemName);
    }

    public function __toString()
    {
        return $this->description;
    }
}