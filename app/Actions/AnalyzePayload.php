<?php

namespace App\Actions;

use Illuminate\Contracts\Support\Arrayable;

class AnalyzePayload implements Actionable
{
    protected int $score = 0;

    protected array $source = [];

    protected array $detected = [];

    /**
     * Create a new instance with the given data to analyze with the given fields.
     *
     * @param Arrayable|array $payload
     * @param array $fields
     */
    public function __construct(Arrayable|array $payload, protected array $fields)
    {
        if ($payload instanceof Arrayable)
        {
            $this->source = $payload->toArray();
        }
        else
        {
            $this->source = $payload;
        }
    }

    public function do() : int
    {
        $this->recursivePIIAnalyser();

        return $this->score;
    }

    protected function recursivePIIAnalyser() : void
    {
        array_walk_recursive($this->source, function ($value, $key) {
            if (isset($this->fields[$key]))
            {
                $this->detected[$key] = $key;

                $this->score += $this->fields[$key];
            }
        });
    }

    public function getDetectedFields()
    {
        $this->recursivePIIAnalyser();
        return $this->detected;
    }
}
