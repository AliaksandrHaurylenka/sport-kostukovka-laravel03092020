<?php

$factory->define(App\Banner::class, function (Faker\Generator $faker) {
    return [
        "link" => $faker->name,
    ];
});
