<?php

namespace Adventurelib;

class Game
{
    protected $rooms = [];
    protected $commands = [];
    protected $currentRoom;
    protected $player;

    public function __construct(\Adventurelib\Player $player = null)
    {
        if ($player == null) {
            $player = new \Adventurelib\Player();
        }
        $this->setPlayer($player);

        // Add in the default "help" command
        $help = new Command('?', function($game) use ($cli) {
            $cli->bold()->out('Available commands:');
            foreach ($game->getCommands() as $command) {
                $cli->out('* '.$command->getMatch());
            }
        });
        $this->addCommand('help', $help);
    }

    public function setPlayer(\Adventurelib\Player $player)
    {
        $this->player = $player;
    }

    public function getPlayer()
    {
        return $this->player;
    }

    public function addRoom(\Adventurelib\Room &$room)
    {
        $this->rooms[] = $room;
    }

    public function addRooms(array $rooms)
    {
        $this->rooms[] = array_merge($this->rooms, $rooms);
    }

    public function getRooms()
    {
        return $this->rooms;
    }

    public function addCommand($name, \Adventurelib\Command $cmd)
    {
        $this->commands[$name] = $cmd;
    }

    public function getCommands()
    {
        return $this->commands;
    }

    public function getCommand($name)
    {
        return (isset($this->commands[$name])) ? $this->commands[$name] : null;
    }

    public function setCurrentRoom(\Adventurelib\Room $room)
    {
        $this->currentRoom = $room;
    }

    public function getCurrentRoom()
    {
        return $this->currentRoom;
    }

    public function getExits()
    {
        return $this->currentRoom->getExits();
    }

    public function input($input)
    {
        // Run through the commands to look for a match
        foreach ($this->commands as $index => $command) {
            if ($input == '?') {
                $this->getCommand('help')->execute($this);
                return;
            }
            $result = $command->checkMatch($input);
            
            if ($result !== false) {
                // Match! perform the command
                $data = array_merge([$this], $result);
                return call_user_func_array([$command, 'execute'], $data);
            }
        }
        // If we get here, no command was found
        echo "I'm sorry, I don't understand that.\n";
    }

    public function run()
    {
        $quit = false;
        while($quit == false) {
            echo '> ';
            $handle = fopen ("php://stdin","r");
            $input = trim(fgets($handle));

            if ($input == 'quit') {
                $quit = true;
                continue;
            }
            
            $result = $this->input($input);
        }
        fclose($handle);
    }
}