<?php

namespace Database\Factories;

use App\Models\Bidding;
use Illuminate\Database\Eloquent\Factories\Factory;

class BiddingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bidding::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'advertisement_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'bidding' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000)
        ];
    }
}
