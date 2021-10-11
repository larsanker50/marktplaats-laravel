<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rubric;

class RubricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rubric::factory(10)->create();
    }
}
