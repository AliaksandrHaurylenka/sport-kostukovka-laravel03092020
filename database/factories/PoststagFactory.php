<?php

$factory->define(App\Poststag::class, function (Faker\Generator $faker) {
    return [
        "post_id" => $faker->randomNumber(2),
        "tag_id" => $faker->randomNumber(2),
    ];
});
