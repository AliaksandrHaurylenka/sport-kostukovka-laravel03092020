<?php

$factory->define(App\Timetable::class, function (Faker\Generator $faker) {
    return [
        "timetable" => $faker->name,
    ];
});
