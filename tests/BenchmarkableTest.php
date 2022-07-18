<?php

namespace Ludo237\Traits\Tests;

use Ludo237\Traits\Tests\Stubs\CommandStub;

class BenchmarkableTest extends TestCase
{
    /**
     * @test
     * @covers \Ludo237\Traits\Benchmarkable::startTime
     * @covers \Ludo237\Traits\Benchmarkable::endTime
     * @covers \Ludo237\Traits\Benchmarkable::getEndTime
     */
    public function it_allows_to_set_a_benchmark_time()
    {
        $command = new CommandStub();
        $command->handle();
        
        // We need to account for small perf issues
        $this->assertGreaterThanOrEqual(5.0, $command->total);
    }
}
