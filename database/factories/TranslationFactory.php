<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */


use App\Models\Entities\Translations\Translation;
use Faker\Generator as Faker;

$factory->define(Translation::class, function (Faker $faker) {
    return [
        'key' => $faker->title
    ];
});
