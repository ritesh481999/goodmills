<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryFarmerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'country_id' => 1,
                'farmer_id' => 1,
            ],
            [
                'country_id' => 2,
                'farmer_id' => 2,
            ],
            [
                'country_id' => 2,
                'farmer_id' => 3,
            ],
            [
                'country_id' => 3,
                'farmer_id' => 4,
            ],
            [
                'country_id' => 3,
                'farmer_id' => 5,
            ],
        ];

        foreach ($data as $value) {
          DB::table('country_farmer')->insert($value);
        }
    }
}
