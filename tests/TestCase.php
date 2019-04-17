<?php

namespace Ludo237\EloquentTraits\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * TestCase
 * @package Ludo237\EloquentTraits\Tests
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;
    
    protected function setUp() : void
    {
        parent::setUp();
    
        $this->loadMigrationsFrom(__DIR__ . "/database/migrations/");
    }
}