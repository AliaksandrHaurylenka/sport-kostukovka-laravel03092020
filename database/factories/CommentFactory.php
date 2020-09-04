<?php

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        "text" => $faker->name,
        "user_id" => $faker->randomNumber(2),
        "post_id" => $faker->randomNumber(2),
        "status" => $faker->randomNumber(2),
    ];
});
