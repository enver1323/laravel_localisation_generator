<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */


use App\Entities\Languages\Language;
use App\Entities\Translations\Entries\TranslationEntry;
use App\Entities\Translations\Translation;
use Faker\Generator as Faker;

$factory->define(TranslationEntry::class, function (Faker $faker) {
    return [
        'translation_id' => Translation::inRandomOrder()->first()->id,
        'language_code' => Language::inRandomOrder()->first()->id,
        'entry' => $faker->title
    ];
});
