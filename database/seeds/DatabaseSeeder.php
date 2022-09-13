<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CountrySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(FAQSeeder::class);
        $this->call(StaticContentSeeder::class);
        $this->call(CommoditySeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(VarietySeeder::class);
        $this->call(SpecificationSeeder::class);
        $this->call(DeliveryLocationSeeder::class);
        $this->call(FarmerSeeder::class);
        $this->call(SellingRequestSeeder::class);
        $this->call(MarketingSeeder::class);
        $this->call(CountryFarmerSeeder::class);
    }
}
