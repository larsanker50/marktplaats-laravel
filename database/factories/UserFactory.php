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
            'postal_code' => rand(1000,9999),
        ];
    }
}
