<?php

namespace Modules\Users\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTesting extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_making_an_api_request()
    {
        $response = $this->postJson('/api/login', ['email' => 'company@mail.co', 'password' => 'password']);
 
        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);
    }
}
