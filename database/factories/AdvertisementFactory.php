<?php

namespace Database\Factories;

use App\Models\advertisement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertisementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = advertisement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'title' => $this->faker->sentence($nbWords = 4),
            'body' => $this->faker->paragraph(3),
            'status' => $this->faker->randomElement($array = array ('available','sold')),
            'premium' => $this->faker->boolean
        ];
    }
}
