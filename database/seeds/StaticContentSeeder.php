<?php

use Illuminate\Database\Seeder;

use App\Models\StaticContent;

class StaticContentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
       
            for ($i = 1; $i <= 3; $i++) {
                StaticContent::create(
                    [
                        'country_id' => $i,
                        'content_type' => $i,
                        'contents' => $faker->text,
                    ]
                );
            }
        
        
    }
}
