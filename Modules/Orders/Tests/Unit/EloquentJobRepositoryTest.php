<?php

namespace Modules\Orders\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EloquentJobRepositoryTest extends TestCase
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
        $response = $this->postJson('/api/login', ['email' => 'company@mail.com', 'password' => 'password']);
 
        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);
    }
}
