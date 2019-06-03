<?php
// phpunit --configuration .phpunit.xml run test
namespace Anax;

use PHPUnit\Framework\TestCase;
use My\Dice\Player;
use My\Dice\RandomSeries;
use My\Dice\Dice;

/**
 * Example test class.
 */
class DiceTest extends TestCase
{
    /**
     * Just assert something is true.
     */
    public function testTrue()
    {
        $this->assertTrue(true);
    }

    public function testPlayer()
    {
        $foxy = new Player("Jon", "Human");
        $this->assertEquals($foxy->type, "human");

        $foxy->total = 100;
        $this->assertEquals($foxy->getTotal(), 100);

        $mark = new Player("Mark", "Human");
        $mark->total = 23;
        $this->assertEquals($mark->getTotal(), 23);
    }

    public function testRandomSeries()
    {
        $rand = new RandomSeries(2, 6);
        $randSeries = $rand->getSeries();
        $this->assertEquals(count($randSeries), 2);
        $this->assertFalse(($randSeries == $rand->getSeries()));
        $this->assertEquals(gettype($randSeries), gettype([1,2]));
    }

    public function testDice()
    {
        $game = new Dice([["Rony","Human"],["Mag","machine"],["Bob","machine"],["Dwight","machine"]]);
        $current = $game->players;
        $this->assertEquals(count($current), 4);
        $game->contestWhoIsFirst();
        $this->assertFalse(($current == $game->players));
        $this->assertEquals(gettype($game->printedPlayers()), gettype("string"));
        $this->assertEquals((boolean) $game->checkWinner(), false);
        $game->players[0]->total = 100;
        $this->assertEquals((boolean) $game->checkWinner(), true);

        $res = $game->moves();
        $this->assertEquals(gettype($res), gettype([1,2]));

        $game02 = new Dice([["Rony","Human"],["Mag","machine"],["Bob","machine"],["Dwight","machine"]]);
        $game02->contestWhoIsFirst();

        $game02->moves();
        $res = $game02->moves();
        $this->assertEquals(count($res), 4);
        $this->assertEquals(gettype($res), gettype([1,2]));
        $game02->moves(1);
        $game02->moves(1);
        $this->assertEquals($game02->pointer, 0);
    }
}
