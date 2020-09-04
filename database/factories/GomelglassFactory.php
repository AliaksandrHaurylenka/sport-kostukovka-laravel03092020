<?php

$factory->define(App\Gomelglass::class, function (Faker\Generator $faker) {
    return [
        "description" => $faker->name,
        "sport" => collect(["tennis","ski","swimming","volleyball","multiathlon","chess","darts","football",])->random(),
    ];
});
