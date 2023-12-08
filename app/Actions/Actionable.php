<?php

namespace App\Actions;

interface Actionable
{
    /**
     * Run the given action.
     *
     * @return mixed
     */
    public function do();
}
