<?php

use App\Models\DeliveryLocation;
use Illuminate\Database\Seeder;

class DeliveryLocationSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Berlin',
            ],
            [
                'name' => 'Humburg',
            ]
        ];

        foreach ($data as $value) {
            DeliveryLocation::create($value);
        }
    }
}
