<?php

namespace My\Dice;

    /**
     * Сreate a player, a class creates a player object with basic attributes
     */

class Player
{

    /**
     * Constructor to initiate an object with the current settings.
     */

    public function __construct($name, $type)
    {
        $this->name = $name;
        $this->count = 0 ;
        $this->total = 0 ;
        $this->type = mb_strtolower($type);
    }

    /**
     * Method asks for total player points
     *
     * @return int Number of points
     */

    public function getTotal()
    {
        return $this->total;
    }
}
