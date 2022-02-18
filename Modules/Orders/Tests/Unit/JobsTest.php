<?php

namespace Modules\Orders\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Passport\Passport;

class jobsTest extends TestCase
{
    /**
     * Create job unit test.
     *
     * @return void
     */

    public function testJobCreatedSuccessfully()
    {
        $user = User::factory()->create();
        Passport::actingAs(
            User::factory()->create(),
            ['api']
        );
        $job_data = [
            "user_id" => 1,
            "title" => "description",
            "description" => "description",
            "status" => "pending",
        ];

        $this->json('POST', 'api/jobs', $job_data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "message" => "Job added successfully"
            ]);
    }
}
