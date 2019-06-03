<?php

namespace My\Dice;

    /**
     * Create a randoms numbers, a class allows you to create an array of
     * random numbers arbitrary length.
     */

class RandomSeries
{
    /**
     *
     * The constructor initializes the class RandomSeries.
     *
     * @param int $count The number of random numbers or the length of the array,
     *                    default 1
     * @param int $range  random number range,
     *                    default 10.
     */

    public function __construct(int $count = 1, int $range = 10)
    {
        $this->count = $count;
        $this->range = $range;
        $this->series = $this->generateSeries($count, $range);
    }

    /**
     * The method implements a set of random numbers based on the rand function.
     *
     * @param int $count Specifies the number of random numbers or the length of the array
     *
     * @param int $range Specifies the end range of a random number.
     *
     * @return array of random numbers
     */

    public function generateSeries(int $count, int $range)
    {
        $series = [];
        for ($i = 0; $i < $count; $i++) {
             $series[] = rand(1, $range);
        }
        return $series;
    }

    /**
     * The method queries the current series of random numbers,
     * and then updates the series.
     *
     * @return array current of random numbers
     */

    public function getSeries()
    {
        $series = $this->series;
        $this->updateSeries();
        return $series;
    }

    /**
     * The method updates a series of random numbers
     *
     * @return  void
     */

    public function updateSeries()
    {
        $this->series = $this->generateSeries($this->count, $this->range);
    }
}
