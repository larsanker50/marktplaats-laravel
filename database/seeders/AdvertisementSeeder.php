<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Advertisement;
use App\Models\Rubric;

class AdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Advertisement::factory(40)->create()->each(function ($advertisement) {
            $rubric = Rubric::factory(2)->create();
            $advertisement->rubric()->saveMany($rubric);
        });
    }
}
