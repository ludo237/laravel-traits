<?php

namespace Ludo237\Traits\Tests;

use Ludo237\Traits\Tests\Stubs\PostStub;
use Ludo237\Traits\Tests\Stubs\UserStub;

class OwnedByUserTest extends TestCase
{
    private UserStub $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserStub::query()->create([
            'uuid' => '123aa-bb456',
            'name' => 'Foo Bar',
            'slug' => 'foo.bar.1',
            'api_key' => '12345abcd',
        ]);
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\OwnedByUser::ownerField
     */
    public function it_returns_the_right_owner_field()
    {
        $this->assertEquals('id', PostStub::ownerField());
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\OwnedByUser::foreignOwnerField
     */
    public function it_returns_the_right_foreign_owner_field()
    {
        $this->assertEquals('user_id', PostStub::foreignOwnerField());
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\OwnedByUser::isOwned
     * @covers \Ludo237\Traits\OwnedByUser::isNotOwned
     * @covers \Ludo237\Traits\OwnedByUser::isOwnedBy
     * @covers \Ludo237\Traits\OwnedByUser::isNotOwnedBy
     * @covers \Ludo237\Traits\OwnedByUser::isOwnedByUserId
     * @covers \Ludo237\Traits\OwnedByUser::isNotOwnedByUserId
     */
    public function it_can_check_if_it_is_owned()
    {
        $post = PostStub::query()->create();

        $anotherPost = PostStub::query()->create([
            'user_id' => $this->user->getKey(),
        ]);

        $this->assertFalse($post->isOwned());
        $this->assertTrue($post->isNotOwned());
        $this->assertFalse($post->isOwnedBy($this->user));
        $this->assertTrue($post->isNotOwnedBy($this->user));
        $this->assertFalse($post->isOwnedByUserId($this->user->getKey()));
        $this->assertTrue($post->isNotOwnedByUserId($this->user->getKey()));

        $this->assertTrue($anotherPost->isOwned());
        $this->assertFalse($anotherPost->isNotOwned());
        $this->assertTrue($anotherPost->isOwnedBy($this->user));
        $this->assertFalse($anotherPost->isNotOwnedBy($this->user));
        $this->assertTrue($anotherPost->isOwnedByUserId($this->user->getKey()));
        $this->assertFalse($anotherPost->isNotOwnedByUserId($this->user->getKey()));
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\OwnedByUser::isNotOwned
     */
    public function it_can_check_if_it_is_not_owned()
    {
        $post = PostStub::query()->create();
        $anotherPost = PostStub::query()->create([
            'user_id' => $this->user->getKey(),
        ]);

        $this->assertTrue($post->isNotOwned());
        $this->assertFalse($anotherPost->isNotOwned());
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\OwnedByUser::owner
     */
    public function user_can_be_set_through_a_convenient_mutator()
    {
        /** @var \Ludo237\Traits\Tests\Stubs\PostStub $post */
        $post = PostStub::query()->create();
        $post->owner = $this->user;

        $this->assertEquals($this->user->getKey(), $post->getAttributeValue('user_id'));
        $this->assertEquals($this->user->getKey(), $post->owner->getKey());
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\OwnedByUser::user
     */
    public function it_inject_the_belongs_to_user_relationship()
    {
        $post = PostStub::query()->create([
            'user_id' => $this->user->getKey(),
        ]);

        $this->assertInstanceOf(UserStub::class, $post->user);
        $this->assertEquals($post->getAttributeValue('user_id'), $post->user->getKey());

        $post = PostStub::query()->create();

        $this->assertNull($post->user);
    }
}
