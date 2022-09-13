<?php

use Illuminate\Database\Seeder;
use App\Models\FAQ;

class FAQSeeder extends Seeder
{
    public function run()
    {
        $items = factory(FAQ::class, 20)->make();

        foreach ($items as $item) {
            FAQ::updateOrCreate($item->toArray());
        }
    }
}
