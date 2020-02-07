<?php

namespace Ludo237\EloquentTraits\Tests;

use Ludo237\EloquentTraits\Tests\Stubs\Post;
use Ludo237\EloquentTraits\Tests\Stubs\User;

/**
 * Class OwnedByUserTest
 * @package \Ludo237\EloquentTraits\Tests;
 */
class OwnedByUserTest extends TestCase
{
    /** @var \Ludo237\EloquentTraits\Tests\Stubs\User */
    private $user;
    
    protected function setUp() : void
    {
        parent::setUp();
        
        $this->user = User::create([
            "uuid" => "123aa-bb456",
            "name" => "Foo Bar",
            "slug" => "foo.bar.1",
            "api_key" => "12345abcd",
        ]);
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\OwnedByUser::ownerField
     */
    public function it_returns_the_right_owner_field()
    {
        $this->assertEquals("id", Post::ownerField());
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\OwnedByUser::foreignOwnerField
     */
    public function it_returns_the_right_foreign_owner_field()
    {
        $this->assertEquals("user_id", Post::foreignOwnerField());
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\OwnedByUser::isOwned
     * @covers \Ludo237\EloquentTraits\OwnedByUser::isOwnedBy
     * @covers \Ludo237\EloquentTraits\OwnedByUser::isOwnedByUserId
     */
    public function it_can_check_if_it_is_owned()
    {
        $post = Post::create();
        
        $anotherPost = Post::create([
            "user_id" => $this->user->id,
        ]);
        
        $this->assertFalse($post->isOwned());
        $this->assertFalse($post->isOwnedBy($this->user));
        $this->assertFalse($post->isOwnedByUserId($this->user->getKey()));
        
        $this->assertTrue($anotherPost->isOwned());
        $this->assertTrue($anotherPost->isOwnedBy($this->user));
        $this->assertTrue($anotherPost->isOwnedByUserId($this->user->getKey()));
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\OwnedByUser::isNotOwned
     */
    public function it_can_check_if_it_is_not_owned()
    {
        $post = Post::create();
        $anotherPost = Post::create([
            "user_id" => $this->user->id,
        ]);
        
        $this->assertTrue($post->isNotOwned());
        $this->assertFalse($anotherPost->isNotOwned());
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\OwnedByUser::scopeOfUser
     */
    public function it_can_be_scoped_by_a_given_user()
    {
        $postOfUser = Post::create([
            "user_id" => $this->user->id,
        ]);
        $anotherPost = Post::create();
        
        $posts = Post::ofUser($this->user)->get();
        
        $this->assertFalse($posts->contains("id", $anotherPost->id));
        $this->assertTrue($posts->contains("id", $postOfUser->id));
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\OwnedByUser::scopeOfUserId
     */
    public function it_can_be_scoped_by_a_given_user_id()
    {
        $postOfUser = Post::create([
            "user_id" => $this->user->id,
        ]);
        $anotherPost = Post::create();
        
        $posts = Post::ofUserId($this->user->id)->get();
        
        $this->assertFalse($posts->contains("id", $anotherPost->id));
        $this->assertTrue($posts->contains("id", $postOfUser->id));
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\OwnedByUser::scopeOfAuthenticatedUser
     */
    public function it_can_be_scoped_by_the_current_authenticated_user()
    {
        $this->actingAs($this->user);
        
        $postOfUser = Post::create([
            "user_id" => $this->user->id,
        ]);
        $anotherPost = Post::create();
        
        $posts = Post::ofAuthenticatedUser()->get();
        
        $this->assertFalse($posts->contains("id", $anotherPost->id));
        $this->assertTrue($posts->contains("id", $postOfUser->id));
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\OwnedByUser::owner
     * @covers \Ludo237\EloquentTraits\OwnedByUser::user
     */
    public function it_inject_the_belongs_to_user_relationship()
    {
        $post = Post::create([
            "user_id" => $this->user->id,
        ]);
        
        $this->assertInstanceOf(User::class, $post->user);
        $this->assertEquals($post->user_id, $post->user->id);
        
        $post = Post::create();
        
        $this->assertNull($post->user);
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\OwnedByUser::setUserAttribute
     */
    public function user_can_be_set_through_a_convenient_mutator()
    {
        /** @var \Ludo237\EloquentTraits\Tests\Stubs\Post $post */
        $post = Post::create();
        $post->user = $this->user;
        
        $this->assertEquals($this->user->id, $post->user_id);
        $this->assertEquals($this->user->id, $post->user->id);
    }
}
