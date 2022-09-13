<?php

use App\Models\Farmer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FarmerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [[
            'name' => "Rory Webber",
            'username' => "Rory",
            'email' => "Rory@gmail.com",
            'company_name' => "webol",
            'pin' => Hash::make("123456"),
            'dialing_code'=>'+91',
            'phone' => "9412123223",
            'address' => "london,uk",
            'country_id' => "1",
            'user_type' => "producer",
            'status' => "1",
        ],
        [
            'name' => "John Cena",
            'username' => "John",
            'email' => "John@gmail.com",
            'company_name' => "dueTrade",
            'pin' => Hash::make("123456"),
            'dialing_code'=>'+91',
            'phone' => "7388337731",
            'address' => "london,uk",
            'country_id' => "1",
            'user_type' => "trader",
            'status' => "1",
        ],
        [
            'name' => "Tom Hardy",
            'username' => "Tom",
            'email' => "tom@gmail.com",
            'company_name' => "webol",
            'pin' => Hash::make("123456"),
            'dialing_code'=>'+91',
            'phone' => "8286366060",
            'address' => "berlin,germany",
            'country_id' => "1",
            'user_type' => "trader",
            'status' => "1",
        ],
        [
            'name' => "Kate winslet",
            'username' => "Kate",
            'email' => "kate@gmail.com",
            'company_name' => "webol",
            'pin' => Hash::make("123456"),
            'dialing_code'=>'+91',
            'phone' => "7400344089",
            'address' => "paris,france",
            'country_id' => "1",
            'user_type' => "trader",
            'status' => "1",
        ],
        [
            'name' => "Taylor Swift",
            'username' => "Taylor",
            'email' => "taylor@gmail.com",
            'company_name' => "dueTrade",
            'pin' => Hash::make("123456"),
            'dialing_code'=>'+91',
            'phone' => "8087888757",
            'address' => "paris,france",
            'country_id' => "1",
            'user_type' => "trader",
            'status' => "1",
        ]];



        foreach($data as $value)
        {
           $farmer = Farmer::create($value);
           $farmer->farmer_device()->create(['fcm_token'=>time(),'device_token'=>'token1','device_type'=>1]);
        }
    }
}
