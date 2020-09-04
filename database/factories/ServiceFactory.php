<?php

$factory->define(App\Service::class, function (Faker\Generator $faker) {
    return [
        "service" => $faker->name,
        "price" => $faker->randomFloat(2, 1, 100),
        "price_the_evening" => $faker->randomFloat(2, 1, 100),
        "price_5_lessons" => $faker->randomFloat(2, 1, 100),
        "price_10_lessons" => $faker->randomFloat(2, 1, 100),
        "price_other" => $faker->randomFloat(2, 1, 100),
    ];
});
