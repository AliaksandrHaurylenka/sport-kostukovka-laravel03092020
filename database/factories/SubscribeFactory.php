<?php

$factory->define(App\Subscribe::class, function (Faker\Generator $faker) {
    return [
        "email" => $faker->safeEmail,
        "token" => $faker->name,
    ];
});
