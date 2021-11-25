<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PostalcodeSeeder::class,
            UserSeeder::class,
            AdvertisementSeeder::class,
            BiddingSeeder::class,
            RubricSeeder::class,
            MessageSeeder::class,
        ]);
    }
}
