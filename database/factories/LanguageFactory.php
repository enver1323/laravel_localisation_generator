<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Languages\Language;
use Faker\Generator as Faker;

$factory->define(Language::class, function (Faker $faker) {
    return [
        'code' => $faker->languageCode,
        'name' => $faker->languageCode,

    ];
});
