<?php

use App\Models\SellingRequest;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SellingRequestSeeder extends Seeder
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
                'date_of_movement' => Carbon::today(),
                'commodity_id' => '1',
                'specification_id' => '1',
                'variety_id' => '1',
                'delivery_location_id' => '1',
                'farmer_id' => '1',
                'country_id' => '2',
                'tonnage' => 58,
                'delivery_method' => '2',
                'postal_code' => '1100022',
            ],
            [
                'date_of_movement' => Carbon::today(),
                'commodity_id' => '2',
                'specification_id' => '2',
                'variety_id' => '2',
                'farmer_id' => '2',
                'country_id' => '3',
                'tonnage' => 87,
                'delivery_method' => '1',
                'delivery_address' => 'bermingham,uk',
            ],
        ];

        foreach ($data as $key => $value) {
            SellingRequest::create($value);
        }
    }
}
