<?php

namespace Modules\Jobs\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Modules\Jobs\Entities\Job;
use Laravel\Passport\Passport;
use Illuminate\Support\Str;


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
            "user_id" => $user->id,
            "title" => "title",
            "description" => "description",
            "status" => "pending",
        ]);

        Job::factory()->create([
            "user_id" => $user->id,
            "title" => "title",
            "description" => "description",
            "status" => "pending",
        ]);

        $this->json('GET', 'api/jobs', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => true,
                // "message" => [
                //     [
                //         "user_id" => 1,
                //         "title" => "title",
                //         "description" => "description",
                //         "status" => "pending",
                //     ],
                //     [
                //         "user_id" => 1,
                //         "title" => "title",
                //         "description" => "description",
                //         "status" => "pending",
                //     ]
                // ],
                "code" => 200
            ]);
    }


    /**
     * /List all jobs of company manager unit test.
     *
     * @return void
     */

    public function testManagerJobsListing($user_type = 'manager')
    {

        $user = User::factory()->create();
        Passport::actingAs(
            User::factory()->create([
                'name' => Str::random(10),
                'email' => Str::random(10).'@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('secret'), // password
                'remember_token' => Str::random(10),
                'user_type' => $user_type
                ]
            ),
            ['api']
        );

        Job::factory()->create([
            "user_id" => $user->id,
            "title" => "title",
            "description" => "description",
            "status" => "pending",
        ]);

        Job::factory()->create([
            "user_id" => $user->id,
            "title" => "title",
            "description" => "description",
            "status" => "pending",
        ]);

        $this->json('GET', 'api/jobs', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => true,
                // "message" => [
                //     [
                //         "user_id" => 1,
                //         "title" => "title",
                //         "description" => "description",
                //         "status" => "pending",
                //     ],
                //     [
                //         "user_id" => 1,
                //         "title" => "title",
                //         "description" => "description",
                //         "status" => "pending",
                //     ]
                // ],
                "code" => 200
            ]);
    }


        /**
     * /List all jobs of regular employee unit test.
     *
     * @return void
     */

    public function testEmployeeJobsListing($user_type = 'regular')
    {

        $user = User::factory()->create();
        Passport::actingAs(
            User::factory()->create([
                'name' => Str::random(10),
                'email' => Str::random(10).'@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('secret'), // password
                'remember_token' => Str::random(10),
                'user_type' => $user_type
                ]
            ),
            ['api']
        );

        Job::factory()->create([
            "user_id" => $user->id,
            "title" => "title",
            "description" => "description",
            "status" => "pending",
        ]);

        Job::factory()->create([
            "user_id" => $user->id,
            "title" => "title",
            "description" => "description",
            "status" => "pending",
        ]);

        $this->json('GET', 'api/jobs', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => true,
                // "message" => [
                //     [
                //         "user_id" => 1,
                //         "title" => "title",
                //         "description" => "description",
                //         "status" => "pending",
                //     ],
                //     [
                //         "user_id" => 1,
                //         "title" => "title",
                //         "description" => "description",
                //         "status" => "pending",
                //     ]
                // ],
                "code" => 200
            ]);
    }
}
