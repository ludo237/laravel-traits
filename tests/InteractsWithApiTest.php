<?php

namespace Ludo237\EloquentTraits\Tests;

use Ludo237\EloquentTraits\Tests\Stubs\User;
use Ludo237\EloquentTraits\Tests\TestCase;

/**
 * Class InteractsWithApiTest
 * @group EntitiesTrait
 * @package Ludo237\EloquentTraits\Tests
 */
class InteractsWithApiTest extends TestCase
{
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\InteractsWithApi::apiField
     */
    public function it_returns_the_right_api_field()
    {
        $this->assertEquals("api_key", User::apiField());
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\InteractsWithApi::bootInteractsWithApi
     */
    public function an_api_key_be_assigned_on_creating()
    {
        // The merge is necessary since password is an hidden attribute
        $user = User::create(["name" => "foo"]);
        
        $this->assertNotNull($user->api_key);
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\InteractsWithApi::setApiKeyAttribute
     */
    public function api_key_will_be_encrypted_by_default()
    {
        $user = User::create(["name" => "foo"]);
        
        $rawApi = $user->getAttributes()["api_key"];
        
        $this->assertNotEquals($user->api_key, $rawApi);
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\InteractsWithApi::getApiKeyAttribute
     */
    public function api_key_will_be_decrypted_by_default()
    {
        $user = User::create(["name" => "foo"]);
        
        $rawApi = $user->getAttribute("api_key");
        
        $this->assertEquals($user->api_key, $rawApi);
    }
    
    /**
     * @test
     * @covers \Ludo237\EloquentTraits\InteractsWithApi::hasApiKey
     * @covers \Ludo237\EloquentTraits\InteractsWithApi::doesNotHaveApiKey
     */
    public function it_can_check_if_model_has_an_api_key()
    {
        $user = User::create(["name" => "foo"]);
        
        $this->assertTrue($user->doesNotHaveApiKey("foobar"));
        $this->assertTrue($user->hasApiKey($user->api_key));
    }
    

}