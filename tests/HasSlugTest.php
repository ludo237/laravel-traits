<?php

namespace Ludo237\EloquentTraits\Tests;

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
    public function it_boots_creating_a_slug_for_the_model()
    {
        $user = User::create(["name" => "foo"]);
        
        $this->assertNotNull($user->slug);
        $this->assertStringContainsString("foo.", $user->slug);
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\HasSlug::scopeWhereSlug
     */
    public function it_can_scope_models_by_slug()
    {
        $sluggable = User::create(["name" => "foo"]);
        
        $fetchedSluggable = User::whereSlug($sluggable->slug)->first();
        
        $this->assertTrue($sluggable->is($fetchedSluggable));
    }
}
