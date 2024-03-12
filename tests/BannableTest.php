<?php

namespace Ludo237\Traits\Tests;

use Illuminate\Support\Facades\Date;
use Ludo237\Traits\Tests\Stubs\UserStub;

class BannableTest extends TestCase
{
    /**
     * @test
     *
     * @covers \Ludo237\Traits\Bannable::banField
     */
    public function it_returns_the_right_ban_field()
    {
        $this->assertEquals('banned_at', UserStub::banField());
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\Bannable::remainingBanDays
     */
    public function it_returns_the_number_of_days_remaining_for_the_ban()
    {
        $user = UserStub::query()->create([
            'name' => 'foo',
            'banned_at' => Date::today()->addDays(10),
        ]);

        $this->assertEquals(10, $user->remainingBanDays());
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\Bannable::isBanned
     * @covers \Ludo237\Traits\Bannable::isNotBanned
     */
    public function it_returns_true_if_an_entity_is_banned()
    {
        $user = UserStub::query()->create([
            'name' => 'foo',
            'banned_at' => Date::today(),
        ]);

        $this->assertTrue($user->isBanned());
        $this->assertFalse($user->isNotBanned());
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\Bannable::isStillBanned
     */
    public function it_returns_true_if_an_entity_is_still_banned_up_until_today()
    {
        $user = UserStub::query()->create([
            'name' => 'foo',
            'banned_at' => Date::today(),
        ]);

        $this->assertTrue($user->isStillBanned());

        $user = UserStub::query()->create([
            'name' => 'foo',
            'banned_at' => Date::today()->subDay(),
        ]);

        $this->assertFalse($user->isStillBanned());
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\Bannable::hasExpiredBan
     */
    public function it_returns_true_if_an_entity_has_an_expired_ban()
    {
        $user = UserStub::query()->create([
            'name' => 'foo',
            'banned_at' => Date::today(),
        ]);

        $this->assertFalse($user->hasExpiredBan());

        $user = UserStub::query()->create([
            'name' => 'foo',
            'banned_at' => Date::today()->subDay(),
        ]);

        $this->assertTrue($user->hasExpiredBan());
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\Bannable::banFor
     * @covers \Ludo237\Traits\Bannable::banForOneDay
     * @covers \Ludo237\Traits\Bannable::banForOneWeek
     * @covers \Ludo237\Traits\Bannable::banForOneMonth
     * @covers \Ludo237\Traits\Bannable::banForOneYear
     * @covers \Ludo237\Traits\Bannable::banForever
     */
    public function it_can_ban_an_entity()
    {
        $user = UserStub::query()->create(['name' => 'foo']);

        $user->banFor($banDate = Date::today()->addDays(4));
        $this->assertDatabaseHas('users', [
            'id' => $user->getKey(),
            'banned_at' => $banDate,
        ]);

        $user->banForOneDay();
        $this->assertDatabaseHas('users', [
            'id' => $user->getKey(),
            'banned_at' => Date::tomorrow(),
        ]);

        $user->banForOneWeek();
        $this->assertDatabaseHas('users', [
            'id' => $user->getKey(),
            'banned_at' => Date::today()->addWeek(),
        ]);

        $user->banForOneMonth();
        $this->assertDatabaseHas('users', [
            'id' => $user->getKey(),
            'banned_at' => Date::today()->addMonth(),
        ]);

        $user->banForOneYear();
        $this->assertDatabaseHas('users', [
            'id' => $user->getKey(),
            'banned_at' => Date::today()->addYear(),
        ]);

        $user->banForever();
        $this->assertDatabaseHas('users', [
            'id' => $user->getKey(),
            'banned_at' => Date::today()->addCentury(),
        ]);
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\Bannable::liftBan
     */
    public function it_can_lift_a_ban()
    {
        $user = UserStub::query()->create([
            'name' => 'foo',
            'banned_at' => Date::today(),
        ]);

        $user->liftBan();

        $this->assertDatabaseHas('users', [
            'id' => $user->getKey(),
            'banned_at' => null,
        ]);
    }
}
