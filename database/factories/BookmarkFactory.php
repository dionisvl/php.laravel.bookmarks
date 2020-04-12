<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bookmark;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Bookmark::class, function (Faker $faker) {
    $name = $faker->name;
    return [
        'title' => $name,
        'slug' => Str::slug($name),
        'favicon' => $faker->uuid,
        'url_origin' => $faker->url,
        'meta_description' => $faker->text(255),
        'meta_keywords' => $faker->text(255),
    ];
});
