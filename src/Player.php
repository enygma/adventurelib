<?php

namespace Adventurelib;

class Player
{
    protected $inventory;

    public function __construct()
    {
        $this->inventory = new Bag();
    }

    public function __get($name)
    {
        if (property_exists($this, $name) == true) {
            return $this->$name;
        }
        return null;
    }

    public function getInventory()
    {
        return $this->inventory;
    }
}