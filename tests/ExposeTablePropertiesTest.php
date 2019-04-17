<?php

namespace Ludo237\EloquentTraits\Tests;

use Ludo237\EloquentTraits\Tests\Stubs\User;

/**
 * Class ExposeTablePropertiesTest
 * @package Ludo237\EloquentTraits\Tests
 */
class ExposeTablePropertiesTest extends TestCase
{
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\ExposeTableProperties::tableName
     */
    public function it_displays_the_table_name()
    {
        $this->assertEquals("users", User::tableName());
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\ExposeTableProperties::primaryKeyName
     */
    public function it_displays_the_primary_key_name()
    {
        $this->assertEquals("id", User::primaryKeyName());
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\ExposeTableProperties::primaryKeyType
     */
    public function it_displays_the_primary_key_type()
    {
        $this->assertEquals("int", User::primaryKeyType());
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\ExposeTableProperties::primaryKey
     */
    public function it_returns_the_complete_set_for_primary_key()
    {
        $this->assertIsArray(User::primaryKey());
        
        $this->assertEquals("id", User::primaryKey()["name"]);
        $this->assertEquals("int", User::primaryKey()["type"]);
    }
}
