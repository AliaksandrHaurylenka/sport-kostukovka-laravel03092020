<?php

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        "title" => $faker->name,
        "slug" => $faker->name,
        "content" => $faker->text,
        "date" => $faker->date("d/m/Y", $max = 'now'),
        //"category_id" => $faker->randomNumber(1),
        //"category_id" => $faker->numberBetween($min = 1, $max = 6),
        "category_id" => 2,
        "user_id" => 1,
        "status" => 1,
        "views" => $faker->randomNumber(2),
        "is_featured" => 1,
        "folder" => $faker->name,
    ];
});
