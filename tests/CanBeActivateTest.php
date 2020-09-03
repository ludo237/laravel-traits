<?php

namespace Ludo237\EloquentTraits\Tests;

use Illuminate\Support\Facades\Date;
use Ludo237\EloquentTraits\Tests\Stubs\User;

/**
 * Class CanBeActivateTest
 * @package Ludo237\EloquentTraits\Tests
 */
class CanBeActivateTest extends TestCase
{
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\CanBeActivate::activateAtField
     */
    public function it_returns_the_right_activate_field()
    {
        $this->assertEquals("activated_at", User::activateAtField());
    }
        
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\CanBeActivate::isActive
     * @covers \Ludo237\EloquentTraits\CanBeActivate::isNotActive
     */
    public function it_returns_true_if_a_model_is_active()
    {
        $user = User::query()->create([
            "name" => "foo",
            "activated_at" => Date::today(),
        ]);
        
        $this->assertTrue($user->isActive());
        $this->assertFalse($user->isNotActive());
    }
    
   
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\CanBeActivate::activate
     */
    public function it_can_activate_a_model()
    {
        $user = User::query()->create([
            "name" => "foo",
            "activated_at" => null,
        ]);
        
        $user->activate();
        
        $this->assertDatabaseMissing("users", [
            "id" => $user->id,
            "activated_at" => null,
        ]);
    }

    /**
     * @test
     * @covers \Ludo237\EloquentTraits\CanBeActivate::deactivate
     */
    public function it_can_deactivate_a_model()
    {
        $user = User::query()->create([
            "name" => "foo",
            "activated_at" => Date::today(),
        ]);
        
        $user->deactivate();
        
        $this->assertDatabaseHas("users", [
            "id" => $user->id,
            "activated_at" => null,
        ]);
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\CanBeActivate::scopeActive
     */
    public function it_can_scope_active_models()
    {
        User::query()->create(["name" => "foo0"]);
        User::query()->create(["name" => "foo1"]);
        User::query()->create([
            "name" => "foo2",
            "activated_at" => Date::today(),
        ]);
        
        $this->assertCount(1, User::active()->get());
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\CanBeActivate::scopeNotActive
     */
    public function it_can_scope_not_active_models()
    {
        User::query()->create(["name" => "foo0"]);
        User::query()->create(["name" => "foo1"]);
        User::query()->create([
            "name" => "foo2",
            "activated_at" => Date::today(),
        ]);
        
        $this->assertCount(2, User::notActive()->get());
    }
}
