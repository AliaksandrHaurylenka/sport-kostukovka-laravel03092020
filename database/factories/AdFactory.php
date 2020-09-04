<?php

$factory->define(App\Ad::class, function (Faker\Generator $faker) {
    return [
        "title" => $faker->name,
        "description" => $faker->name,
        "date" => $faker->date("d/m/Y", $max = 'now'),
    ];
});
