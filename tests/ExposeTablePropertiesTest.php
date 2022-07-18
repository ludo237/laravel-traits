<?php

namespace Ludo237\Traits\Tests;

use Ludo237\Traits\Tests\Stubs\UserStub;

class ExposeTablePropertiesTest extends TestCase
{
    /**
     * @test
     * @covers \Ludo237\Traits\ExposeTableProperties::tableName
     */
    public function it_displays_the_table_name()
    {
        $this->assertEquals("users", UserStub::tableName());
    }
    
    /**
     * @test
     * @covers \Ludo237\Traits\ExposeTableProperties::primaryKeyName
     */
    public function it_displays_the_primary_key_name()
    {
        $this->assertEquals("id", UserStub::primaryKeyName());
    }
    
    /**
     * @test
     * @covers \Ludo237\Traits\ExposeTableProperties::primaryKeyType
     */
    public function it_displays_the_primary_key_type()
    {
        $this->assertEquals("int", UserStub::primaryKeyType());
    }
    
    /**
     * @test
     * @covers \Ludo237\Traits\ExposeTableProperties::primaryKey
     */
    public function it_returns_the_complete_set_for_primary_key()
    {
        $this->assertIsArray(UserStub::primaryKey());
        
        $this->assertEquals("id", UserStub::primaryKey()["name"]);
        $this->assertEquals("int", UserStub::primaryKey()["type"]);
    }
}
