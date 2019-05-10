<?php

namespace Mos\Guess;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int $number   The current secret number.
     * @var int $tries    Number of tries a guess has been made.
     */

    private $number;
    public $tries;


    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */

    // был в скобках на 31 // int $number = -1,

    public function __construct(int $tries = 6)
    {
        $this->number = $this->random();
        $this->tries = $tries;
    }

    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return int number 1-100
     */

    public function random()
    {
        return rand(1, 100);
    }


    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */
    public function tries()
    {

        return $this->tries;
    }




    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */

    public function number()
    {
        return $this->number;
    }


    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */

    public function makeGuess($number)
    {


        $number = (int) $number;

        if ($number > 100 or $number < 1) {
            throw new GuessException('incorrect value');
        }


        if ($number === $this->number()) {
            return "Your guess $number is CORRECT";
        } else {
            return $this->status_message("help message", $number);
        }
    }

    /**
     * Generates the current status of the message for the player.
     *
     * @param string $query    Response commands. Required parameter.
     *
     * @param int    $number   The current number input user, default 0.
     *                         Based on user input, a corresponding message is issued.
     *
     * @return string to show the status of the guess made.
     */

    public function statusMessage($query, $number = 0)
    {

        switch ($query) {
            case 'Cheat':
                return "<span> CHEAT: Current number is {$this->number()} </span>";
                break;

            case 'help message':
                if ($number > $this->number()) {
                    return "Your guess $number is TOO HIGH";
                } elseif ($number < $this->number()) {
                    return "Your guess $number is TOO LOW";
                }
                break;

            default:
                return "";
                break;
        }
    }
}
