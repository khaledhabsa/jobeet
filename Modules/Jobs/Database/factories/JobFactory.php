<?php
namespace Modules\Jobs\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Jobs\Entities\Job;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // fixed user id and job status
            // unitests will change user id dynamicaly based on created user object
            'user_id' => 1,
            'title' => $this->faker->name(),
            'description' => $this->faker->text(),
            'status' => 'pending',
        ];
    }
}

