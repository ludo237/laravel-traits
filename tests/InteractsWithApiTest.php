<?php

namespace Ludo237\Traits\Tests;

use Ludo237\Traits\Tests\Stubs\UserStub;

class InteractsWithApiTest extends TestCase
{
    /**
     * @test
     *
     * @covers \Ludo237\Traits\InteractsWithApi::apiField
     */
    public function it_returns_the_right_api_field()
    {
        $this->assertEquals('api_key', UserStub::apiField());
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\InteractsWithApi::bootInteractsWithApi
     */
    public function an_api_key_be_assigned_on_creating()
    {
        // The merge is necessary since password is an hidden attribute
        $user = UserStub::query()->create(['name' => 'foo']);

        $this->assertNotNull($user->api_key);
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\InteractsWithApi::apiKey
     */
    public function api_key_will_be_encrypted_by_default()
    {
        $user = UserStub::query()->create(['name' => 'foo']);

        $rawApi = $user->getAttributes()['api_key'];

        $this->assertNotEquals($user->api_key, $rawApi);
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\InteractsWithApi::apiKey
     */
    public function api_key_will_be_decrypted_by_default()
    {
        $user = UserStub::query()->create(['name' => 'foo']);

        $rawApi = $user->getAttribute('api_key');

        $this->assertEquals($user->api_key, $rawApi);
    }

    /**
     * @test
     *
     * @covers \Ludo237\Traits\InteractsWithApi::hasApiKey
     * @covers \Ludo237\Traits\InteractsWithApi::doesNotHaveApiKey
     */
    public function it_can_check_if_model_has_an_api_key()
    {
        $user = UserStub::query()->create(['name' => 'foo']);

        $this->assertTrue($user->doesNotHaveApiKey('foobar'));
        $this->assertTrue($user->hasApiKey($user->api_key));
    }
}
