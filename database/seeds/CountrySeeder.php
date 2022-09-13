<?php

use Illuminate\Database\Seeder;

use App\Models\CountryMaster;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'United Kingdom',
                'language' => 'en',
                'direction' => 'ltr',
                'abbreviation' => 'UK',
                'time_zone' => 'GMT',
                'duration' => '1',
        
            ],
            [
                'name' => 'Hungary',
                'language' => 'hu',
                'direction' => 'ltr',
                'abbreviation' => 'HU',
                'time_zone' => 'CET',
                'duration' => '3',
            ],
            [
                'name' => 'Austria',
                'language' => 'de',
                'direction' => 'ltr',
                'abbreviation' => 'AUS',
                'time_zone' => 'CET',
                'duration' => '7',
            ],
            // [
            //     'name' => 'Poland',
            //     'language' => 'pl',
            //     'direction' => 'ltr',
            //     'abbreviation' => 'PL',
            //     'time_zone' => 'CET',
            //     'duration' => '15',
            // ]
        ];

        foreach ($data as $value) {
            CountryMaster::create($value);
        }
    }
}
