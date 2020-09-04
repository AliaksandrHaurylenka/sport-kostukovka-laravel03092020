<?php

$factory->define(App\Pride::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
        "description" => $faker->name,
        "sport_section" => collect(["swimming","wrestling","light athletics","heavy athletics","football","volleyball",])->random(),
    ];
});
