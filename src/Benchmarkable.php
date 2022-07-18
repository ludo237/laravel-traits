<?php

namespace Ludo237\Traits;

trait Benchmarkable
{
    protected float $commandStarts;
    protected string $commandEnds;
    
    public function startTime() : void
    {
        $this->commandStarts = microtime(true);
    }
    
    public function endTime() : void
    {
        $this->commandEnds = number_format((microtime(true) - $this->commandStarts) * 1000, 2);
    }
    
    public function getEndTime() : string
    {
        return $this->commandEnds;
    }
}
