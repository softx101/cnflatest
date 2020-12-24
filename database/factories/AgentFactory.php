<?php

namespace Database\Factories;

use App\Models\Agent;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Agent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {



        return [
            'ain_no' => $this->faker->unique()->numberBetween(1000, 5000),
            'name' => $this->faker->name,
            'owners_name' => $this->faker->name,
            'photo' => $this->faker->imageUrl(640, 480, 'business'),
            'destination' => $this->faker->address,
            'office_address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'house' => $this->faker->numberBetween(1,500),
            'email' => $this->faker->safeEmail,
            'note' => $this->faker->sentence

        ];
    }
}
