<?php

namespace Adventurelib;

class Command
{
    protected $match = '';
    protected $func;
    
    public function __construct($match, Callable $func)
    {
        $this->match = $match;
        $this->func = $func;
    }

    public function getMatch()
    {
        return $this->match;
    }

    public function checkMatch($input)
    {
        $match = preg_quote($this->match, '/');

        // Replace any ALL CAPS strings with wildcards
        $match = preg_replace('/[A-Z]+/', '(.+)', $match);
        $result = preg_match('/'.$match.'/', $input, $matches);

        if ($result > 0) {
            array_shift($matches);
            return $matches;
        } else {
            return false;
        }
    }

    public function execute(\Adventurelib\Game $game, ...$data)
    {
        $data = array_merge([$game], $data);
        return call_user_func_array($this->func, $data);
    }
}