<?php

use App\Models\SpecificationMaster;
use Illuminate\Database\Seeder;

class SpecificationSeeder extends Seeder
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
                'name' => 'LONDON WHEAT',
                'commodity_id' => 1,
            ],
            [
                'name' => 'BASMATI RICE',
                'commodity_id' => 2,
            ]
        ];  
        foreach ($data as $value) {
            SpecificationMaster::create($value);
        }
    }
}
