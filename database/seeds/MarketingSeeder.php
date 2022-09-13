<?php

use Illuminate\Database\Seeder;

use App\Models\Marketing;

use Carbon\Carbon;

class MarketingSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $images = ['ByByz1xMdC.jpg', 'GScnzGOQ96.png', 'QBHg9GhFs1.png', '4PjP5CHOdU.jpg', 'tqKVqJqhM1.jpg', 'mM2g5gCFmE.jpg'];

        $image_files = ['4zaXPZFikd.png', '110ue5zBMm.jpg', 'a56jSpLWd7.jpg', 'BC1sytEu7J.png', 'CXYKZROpRk.jpeg', 'doXOkStF9E.jpg', 'ztyoUHTWwy.jpg', 'WgUcPsX2si.png', 'lTDpOzZ5xc.png', 'y81o6pw4Pd.png'];


        $c = 1;
        for ($i = 1; $i <= 6; $i++) {
            $k = rand(0, 5);


            $marketing = Marketing::create(
                [
                    'title' => $faker->company,
                    'short_description' => substr($faker->text, 0, 50),
                    'description' => $faker->text,
                    'image' => "marketing/image/$images[$k]",
                    'country_id' => $c,
                    'publish_on' => Carbon::now(),
                ]
            );
            if ($i % 2 == 0) {
                $c++;
            }
            for ($l = 1; $l <= rand(0, 10); $l++) {

                $selected_images =  $image_files[$l];

                $selectedArrayImages = explode('.', $selected_images);

                $data['file_name'] = 'marketing/files/' . $selected_images;
                $data['marketing_id'] = $marketing->id;
                $data['file_mime_type'] = end($selectedArrayImages) == 'png' ? 'image/png' : 'image/jpeg';
                $marketing->marketing_files()->create($data);
            }
        }
    }
}
