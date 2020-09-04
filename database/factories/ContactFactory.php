<?php

$factory->define(App\Contact::class, function (Faker\Generator $faker) {
    return [
        "email" => $faker->safeEmail,
        "phone" => $faker->name,
    ];
});
