<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bidding;

class BiddingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bidding::factory(40)->create();
    }
}
