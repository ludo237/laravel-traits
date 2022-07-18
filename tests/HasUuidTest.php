<?php

namespace Ludo237\Traits\Tests;

use Ludo237\Traits\Tests\Stubs\UserStub;
use Ramsey\Uuid\Uuid;

class HasUuidTest extends TestCase
{
    /**
     * @test
     * @covers \Ludo237\Traits\HasUuid::uuidField
     */
    public function it_returns_the_right_uuid_field()
    {
        $this->assertEquals("uuid", UserStub::uuidField());
    }
    
    /**
     * @test
     * @covers \Ludo237\Traits\HasUuid::bootHasUuid
     */
    public function an_uuid_will_be_assigned_on_creating()
    {
        $user = UserStub::query()->create(["name" => "foo"]);
        
        $this->assertTrue(
            Uuid::isValid($user->uuid)
        );
    }
    
    /**
     * @test
     * @covers \Ludo237\Traits\HasUuid::shortUuid
     */
    public function it_returns_the_short_uuid()
    {
        /** @var \Ludo237\Traits\Tests\Stubs\UserStub $user */
        $user = UserStub::query()->create(["name" => "foo"]);
        
        $this->assertStringEndsWith($user->short_uuid, $user->uuid);
    }
}
