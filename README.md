# PHP Adventurelib

The PHP Adventurelib library is a PHP implementation of the [Python adventurelib library](https://adventurelib.readthedocs.io), trying to stay as faithful to the functionality as possible.

There are differences between how the two languages function that make the interfaces a bit different, but the spirit of the library is the same: to provide a simple structure to create text-based adventure games.

## Making a simple game

Here's an example of creating a simple one-room game. In a PHP file (such as `game.php`) put the following:

```php
<?php

require_once __DIR__.'/vendor/autoload.php';

$game = new \Adventurelib\Game();
$game->addRoom(
    new \Adventurelib\Room('Test Room 1', 'Just a basic room with not much in it')
);

$game->run();

?>
```

Then you can run this game on the command line: `php game.php`. You'll be presented with a '>` prompt waiting for your input. In a simple game like this, only one command is included: `help`.

## Adding commands

To add in additional commands, use the `\Adventurelib\Command` class to create an instance. The first parameter is the command match pattern and the second is the closure to execute when the command is called. For example, to add a "look" command to show information about the current room, you'd use this code:

```php
<?php
$look = new \Adventurelib\Command('look', function($game) use ($cli) {
    $room = $game->getCurrentRoom();
    echo $room."\n";

    // List out items in the room
    $itemList = [];
    foreach ($room->items as $item) {
        $itemList[] = $item->getName();
    }
    echo "You see ".implode(", ", $itemList);

    // List the exits
    echo 'You can exit '.implode(', ', array_keys($room->getExits()));
});
$game->addCommand('look', $look);
?>
```