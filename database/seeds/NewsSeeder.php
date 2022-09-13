<?php

use Carbon\Carbon;
use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $faker = Faker\Factory::create();
         $images = ['2ulbc9qhv7.jpg', 'A7PG8jdEd7.jpg', 'DsJCwH9tqG.png', 'EjOJuXUbUr.jpeg', 'pyNs2Q0Qeq.jpg', 'Uf9dhEG40J.png'];
         for($j = 1; $j<=2;$j++)
         {
             $type = $j;
        
         for ($i = 1; $i <= 3; $i++) {
            $k = rand(0, 5);
            News::create(
                [
                    'title' => $faker->company,
                    'short_description' => substr($faker->text,0, 50),
                    'description' => $faker->text,
                    'image' => "news/image/$images[$k]",
                    'country_id' => $i,
                    'date_time' => Carbon::now(),
                    'type' => $type,
                ]
            );
        }
    }
      
    }
}
