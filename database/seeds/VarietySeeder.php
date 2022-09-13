<?php

use App\Models\Variety;
use Illuminate\Database\Seeder;

class VarietySeeder extends Seeder
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
                'name' => 'WHEAT FLOUR',
                'commodity_id' => 1,
            ],
            [
                'name' => 'SELLA BASMATI RICE',
                'commodity_id' => 2,
            ]
        ];  
        foreach ($data as $value) {
            Variety::create($value);
        }
    }
}
