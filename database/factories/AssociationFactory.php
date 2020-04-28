<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Association;
use Faker\Generator as Faker;

$factory->define(Association::class, function (Faker $faker) use ($factory) {
    return [
        'name' => $faker->name(),
        'desc' => $faker->realText(),
        'color' => $faker->hexColor,
        'president_id' => $factory->create(App\User::class)->id
    ];
});
