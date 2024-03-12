<?php

namespace Ludo237\Traits\Tests;

use Illuminate\Support\Facades\Date;
use Ludo237\Traits\Tests\Stubs\UserStub;

class CanBeActivateTest extends TestCase
{
    /**
     * @test
     *
     * @covers \Ludo237\Traits\CanBeActivate::activateAtField
     */
    public function it_returns_the_right_activate_field()
    {
        $this->assertEquals('activated_at', UserStub::activateAtField());
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\CanBeActivate::isActive
     * @covers \Ludo237\Traits\CanBeActivate::isNotActive
     */
    public function it_returns_true_if_a_model_is_active()
    {
        $user = UserStub::query()->create([
            'name' => 'foo',
            'activated_at' => Date::today(),
        ]);

        $this->assertTrue($user->isActive());
        $this->assertFalse($user->isNotActive());
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\CanBeActivate::activate
     */
    public function it_can_activate_a_model()
    {
        $user = UserStub::query()->create([
            'name' => 'foo',
            'activated_at' => null,
        ]);

        $user->activate();

        $this->assertDatabaseMissing('users', [
            'id' => $user->getKey(),
            'activated_at' => null,
        ]);
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\CanBeActivate::deactivate
     */
    public function it_can_deactivate_a_model()
    {
        $user = UserStub::query()->create([
            'name' => 'foo',
            'activated_at' => Date::today(),
        ]);

        $user->deactivate();

        $this->assertDatabaseHas('users', [
            'id' => $user->getKey(),
            'activated_at' => null,
        ]);
    }
}
