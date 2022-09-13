<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\News;
use Faker\Generator as Faker;

$factory->define(News::class, function (Faker $faker) {
    return [
        'title' => $faker->company,
        'short_description' => $faker->text,
        'description' => $faker->text,
        'image' => sprintf('/image/%s.png', $faker->firstName),
        'status' => $faker->boolean
    ];
});
