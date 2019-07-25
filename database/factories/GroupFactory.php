<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Groups\Group;
use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
