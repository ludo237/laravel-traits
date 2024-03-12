<?php

namespace Ludo237\Traits\Tests\Stubs;

use Illuminate\Console\Command;
use Ludo237\Traits\Benchmarkable;

class CommandStub extends Command
{
    use Benchmarkable;

    protected $signature = 'fake:command';

    public float $total = 0;

    public function handle(): int
    {
        $this->startTime();

        sleep(5);

        $this->endTime();

        $this->total = floatval($this->getEndTime());

        return 1;
    }
}
