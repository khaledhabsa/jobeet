<?php

namespace Modules\Orders\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Modules\Orders\Entities\Job;
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


        /**
     * /List all job unit test.
     *
     * @return void
     */

    public function testJobsListedSuccessfully()
    {

        $user = User::factory()->create();
        Passport::actingAs(
            User::factory()->create(),
            ['api']
        );

        Job::factory()->create([
            "user_id" => 1,
            "title" => "title",
            "description" => "description",
            "status" => "pending",
        ]);

        Job::factory()->create()([
            "user_id" => 2,
            "title" => "title",
            "description" => "description",
            "status" => "pending",
        ]);

        $this->json('GET', 'api/jobs', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => true,
                "message" => [
                    [
                        "user_id" => 1,
                        "title" => "title",
                        "description" => "description",
                        "status" => "pending",
                    ],
                    [
                        "user_id" => 2,
                        "title" => "title",
                        "description" => "description",
                        "status" => "pending",
                    ]
                ],
                "code" => 200
            ]);
    }
}
