<?php

namespace App\Library;

class PiiAccessDescriptor
{
    public int $score = 0;

    public function __construct()
    {

    }

    /**
     * @param int $score
     * @return PiiAccessDescriptor
     */
    public function setScore(int $score) : self
    {
        $this->score = $score;

        return $this;

    }
}
