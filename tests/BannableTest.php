<?php

namespace Ludo237\EloquentTraits\Tests;

use Ludo237\EloquentTraits\Bannable;
use Ludo237\EloquentTraits\Tests\Stubs\User;

/**
 * Class BannableTest
 * @package Ludo237\EloquentTraits\Tests
 */
class BannableTest extends TestCase
{
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\Bannable::banField
     */
    public function it_returns_the_right_ban_field()
    {
        $this->assertEquals("banned_at", User::banField());
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\Bannable::remainingBanDays
     */
    public function it_returns_the_number_of_days_remaining_for_the_ban()
    {
        $user = User::create([
            "name" => "foo",
            "banned_at" => Date::today()->addDays(10),
        ]);
        
        $this->assertEquals(10, $user->remainingBanDays());
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\Bannable::isBanned
     * @covers \Ludo237\EloquentTraits\Bannable::isNotBanned
     */
    public function it_returns_if_an_entity_is_banned()
    {
        $user = User::create([
            "name" => "foo",
            "banned_at" => Date::today(),
        ]);
        
        $this->assertTrue($user->isBanned());
        $this->assertFalse($user->isNotBanned());
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\Bannable::isStillBanned
     */
    public function it_returns_if_an_entity_is_still_banned_up_until_today()
    {
        user = User::create([
            "name" => "foo",
            "banned_at" => Date::today(),
        ]);
        
        $this->assertTrue($user->isStillBanned());
        
        $user = User::create([
            "name" => "foo",
            "banned_at" => Date::today()->subDay(),
        ]);
        
        $this->assertFalse($user->isStillBanned());
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\Bannable::hasExpiredBan
     */
    public function it_returns_if_an_entity_has_an_expired_ban()
    {
        user = User::create([
            "name" => "foo",
            "banned_at" => Date::today(),
        ]);
        
        $this->assertFalse($user->hasExpiredBan());
        
        $user = User::create([
            "name" => "foo",
            "banned_at" => Date::today()->subDay(),
        ]);
        
        $this->assertTrue($user->hasExpiredBan());
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\Bannable::banFor
     * @covers \Ludo237\EloquentTraits\Bannable::banForOneDay
     * @covers \Ludo237\EloquentTraits\Bannable::banForOneWeek
     * @covers \Ludo237\EloquentTraits\Bannable::banForOneMonth
     * @covers \Ludo237\EloquentTraits\Bannable::banForOneYear
     * @covers \Ludo237\EloquentTraits\Bannable::banForever
     */
    public function it_can_ban_an_entity()
    {
        $user = User::create(["name" => "foo"]);
        
        $user->banFor($banDate = Date::today()->addDays(4));
        $this->assertDatabaseHas("users", [
            "id" => $user->id,
            "banned_at" => $banDate,
        ]);
        
        $user->banForOneDay();
        $this->assertDatabaseHas("users", [
            "id" => $user->id,
            "banned_at" => Date::tomorrow(),
        ]);
        
        $user->banForOneWeek();
        $this->assertDatabaseHas("users", [
            "id" => $user->id,
            "banned_at" => Date::today()->addWeek(),
        ]);
        
        $user->banForOneMonth();
        $this->assertDatabaseHas("users", [
            "id" => $user->id,
            "banned_at" => Date::today()->addMonth(),
        ]);
        
        $user->banForOneYear();
        $this->assertDatabaseHas("users", [
            "id" => $user->id,
            "banned_at" => Date::today()->addYear(),
        ]);
        
        $user->banForever();
        $this->assertDatabaseHas("users", [
            "id" => $user->id,
            "banned_at" => Date::today()->addCentury(),
        ]);
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\Bannable::liftBan
     */
    public function it_can_lift_a_ban()
    {
        $user = User::create([
            "name" => "foo",
            "banned_at" => Date::today(),
        ]);
        
        $user->liftBan();
        
        $this->assertDatabaseHas("users", [
            "id" => $user->id,
            "banned_at" => null,
        ]);
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\Bannable::scopeBanned
     */
    public function it_can_scope_banned_entities()
    {
        User::create(["name" => "foo0"]);
        User::create(["name" => "foo1"]);
        User::create([
            "name" => "foo2",
            "banned_at" => Date::today(),
        ]);
        
        $this->assertCount(1, User::banned()->get());
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\Bannable::scopeNotBanned
     */
    public function it_can_scope_not_banned_entities()
    {
        User::create(["name" => "foo0"]);
        User::create(["name" => "foo1"]);
        User::create([
            "name" => "foo2",
            "banned_at" => Date::today(),
        ]);
        
        $this->assertCount(2, User::notBanned()->get());
    }
}