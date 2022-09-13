<?php

use App\Models\FAQ;
use Faker\Generator as Faker;

$factory->define(FAQ::class, function (Faker $faker) {
    return [
        'country_id' => 1,
        'question' => $faker->company,
        'answer' => $faker->text,
    ];
});
