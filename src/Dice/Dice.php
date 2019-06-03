<?php
    
namespace My\Dice;

    /**
     * Dice Process Management Class. High level class
     */
class Dice
{
    /**
     * The constructor initializes the game. Adds all members.
     * Sets the cursor to 0.
     *
     * @param array $players The two-dimensional array contains all
     *                       the players who will participate in the game.
     *
     * @return  void
     */

    public function __construct($players)
    {
        $this->players = [];
        for ($i = 0; $i < count($players); $i++) {
            $name = $players[$i][0];
            $type = $players[$i][1];
            $this->players[] = new Player($name, $type);
        }
        $this->number_of_players = count($players);
        $this->pointer = 0;
    }

    /**
     * The method sorts an array from larger to smaller based on the
     * numbers received by players. Simulated a quiz who is first.
     *
     * @return  void
     */

    public function contestWhoIsFirst()
    {
        $rand = new RandomSeries(1, 6);
        $newOrder = [];

        for ($i = 0; $i < $this->number_of_players; $i++) {
            $number = $rand->getSeries()[0];
            $player = $this->players[$i];
            $newOrder[] = [$player,$number];
        }

        usort($newOrder, function ($value01, $value02) {
            return $value01[1] < $value02[1];
        });

        $this->players = [];

        for ($i = 0; $i < $this->number_of_players; $i++) {
            $this->players[] = $newOrder[$i][0];
        }
    }

    /**
     * The method implements the display of information about players.
     *
     * @return string Html code
     */

    public function printedPlayers()
    {
        $info = "";
        for ($i = 0; $i < count($this->players); $i++) {
            $info .= ($i + 1) . ". " . $this->players[$i]->name . "\ttotal = " . $this->players[$i]->total . ' ('. $this->players[$i]->type .') ' . "<br>";
        }
        return $info;
    }

    /**
     * Method checks a condition greater than 100 (points)
     *
     * @return object class Player or false if the condition is not met
     */

    public function checkWinner()
    {
        for ($i = 0; $i < count($this->players); $i++) {
            if ($this->players[$i]->total >= 100) {
                return $this->players[$i];
            }
        }
        return false;
    }

    /**
     * Functional method that implements the game step
     *
     * @param int $skip Simulated throw skip,
     *                  default 0 (do not miss)
     *
     * @return array game state
     */

    public function moves($skip = 0)
    {
        $rand = new RandomSeries(2, 6);

        if ($this->checkWinner()) {
            $name = $this->checkWinner()->name;
            return ["winner", $name];
        }
        $throw = $rand->getSeries();
        if ($skip) {
            "skip the throw (Human)";
        } else {
            if (in_array(1, $throw)) {
                "Ups! Zero total";
                // Строка ниже удалит ВСЕ выигранные очки.
                // $this->players[$this->pointer]->total = 0;
            } else {
                $this->players[$this->pointer]->total += array_sum($throw);
                $this->players[$this->pointer]->count += 1;
            }
        }
        $this->pointer += 1;
        if ($this->pointer == $this->number_of_players) {
            $this->pointer = 0;
        }
        return [ "next",
                  $this->players[$this->pointer]->name,
                  $this->players[$this->pointer]->type,
                  $throw,
               ];
    }
}
