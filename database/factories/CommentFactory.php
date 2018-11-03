<?php

use Faker\Generator as Faker;

$factory->define(\App\Comment::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'email' => $faker->email,
        'content' => $faker->sentence,
        'ip' => $faker->ipv4
    ];
});
