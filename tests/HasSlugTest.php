<?php

namespace Ludo237\EloquentTraits\Tests;

use Illuminate\Support\Str;
use Ludo237\EloquentTraits\HasSlug;
use Ludo237\EloquentTraits\Tests\Stubs\User;

/**
 * Class HasSlugTest
 * @package Ludo237\EloquentTraits\Tests
 */
class HasSlugTest extends TestCase
{
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\HasSlug::sluggableKey
     */
    public function it_has_a_sluggable_key()
    {
        $this->assertEquals("name", HasSlug::sluggableKey());
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\HasSlug::separator
     */
    public function it_has_a_separator()
    {
        $this->assertEquals(".", HasSlug::separator());
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\HasSlug::slugKey
     */
    public function it_has_a_slug_key()
    {
        $this->assertEquals("slug", HasSlug::slugKey());
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\HasSlug::bootHasSlug
     */
    public function it_creates_a_slug_if_not_provided_when_creating()
    {
        $user = User::query()->create(["name" => "foo"]);
        
        $slug = $user->getAttributeValue("slug");
        $slug = explode(".", $slug);
        
        $this->assertNotNull($slug);
        $this->assertEquals(8, strlen($slug[1]));
        $this->assertEquals(Str::slug($user->getAttributeValue("name")), $slug[0]);
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\HasSlug::bootHasSlug
     */
    public function it_does_not_create_a_slug_if_provided_when_creating()
    {
        $user = User::query()->create(["name" => "foo", "slug" => "foo.bar_baz"]);
        
        $this->assertEquals("foo.bar_baz", $user->getAttributeValue("slug"));
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\HasSlug::bootHasSlug
     */
    public function it_creates_a_slug_if_not_provided_when_updating()
    {
        $user = User::query()->create(["name" => "foo", "slug" => "foo.bar_baz"]);
        
        $user->update([
            "slug" => null,
        ]);
        
        $slug = $user->getAttributeValue("slug");
        $slug = explode(".", $slug);
        
        $this->assertNotNull($slug);
        $this->assertEquals(8, strlen($slug[1]));
        $this->assertEquals(Str::slug($user->getAttributeValue("name")), $slug[0]);
        
        // Better safe than sorry
        $user->update([
            "slug" => "",
        ]);
        
        $slug = $user->getAttributeValue("slug");
        $slug = explode(".", $slug);
        
        $this->assertNotNull($slug);
        $this->assertEquals(8, strlen($slug[1]));
        $this->assertEquals(Str::slug($user->getAttributeValue("name")), $slug[0]);
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\HasSlug::bootHasSlug
     */
    public function it_does_not_create_a_slug_if_provided_when_updating()
    {
        $user = User::query()->create(["name" => "foo", "slug" => "foo.bar_baz"]);
        
        $user->update([
            "name" => "new name",
            "slug" => "foo.baz",
        ]);
        
        $this->assertEquals("foo.baz", $user->getAttributeValue("slug"));
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\HasSlug::scopeWhereSlug
     */
    public function it_can_scope_models_by_slug()
    {
        $user = User::query()->create(["name" => "foo"]);
        
        $fetchedUser = User::whereSlug($user->slug)->first();
        
        $this->assertTrue($user->is($fetchedUser));
    }
}
