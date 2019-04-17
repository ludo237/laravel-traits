<?php

namespace Ludo237\EloquentTraits\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
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
        $user = DB::table("users")->where("id", "=", 1)->first();
        
        $this->assertNull($user);
        
        $columns = Schema::getColumnListing("users");
        $this->assertEquals([
            "id",
            "uuid",
            "slug",
            "name",
            "created_at",
            "updated_at",
        ], $columns);
    }
    
}