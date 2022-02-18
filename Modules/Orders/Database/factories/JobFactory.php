<?php
namespace Modules\Orders\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Orders\Entities\JobFactory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->name(),
            'title' => $this->faker->name(),
            'description' => $this->faker->text(),
            'status' => $this->faker->contract(),
        ];
    }
}

