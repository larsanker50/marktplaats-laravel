<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'password' => bcrypt('password'),
            'email' => $this->faker->unique()->safeEmail,
            'residence' => $this->faker->unique()->address,
            'postalcode_id' => $this->faker->numberBetween($min = 1, $max = 4699),
        ];
    }
}
