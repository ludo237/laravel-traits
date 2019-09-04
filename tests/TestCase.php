<?php

namespace Ludo237\EloquentTraits\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

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
    
    
    /** @test */
    public function it_runs_the_migrations()
    {
        $columns = Schema::getColumnListing("users");
        $this->assertEquals([
            "id",
            "uuid",
            "api_key",
            "slug",
            "name",
            "banned_at",
            "created_at",
            "updated_at",
        ], $columns);
    }
    
}