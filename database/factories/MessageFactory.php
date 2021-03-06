<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'from_user_id' => $this->faker->numberBetween($min = 1, $max = User::count()),
            'to_user_id' => $this->faker->numberBetween($min = 1, $max = User::count()),
            'body' => $this->faker->sentence
        ];
    }
}
