<?php

namespace Adventurelib;

class Item
{
    protected $name = '';
    protected $description = '';
    protected $aliases = [];
    protected $takeable = true;

    public function __construct($name, $description, array $aliases = [])
    {
        $this->setName($name);
        $this->setDescription($description);
        $this->setAliases($aliases);
    }

    public function isTakeable()
    {
        return $this->takeable;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function __toString()
    {
        return $this->description;
    }

}