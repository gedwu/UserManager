<?php

use Faker\Generator as Faker;

$factory->define(UserManager\UserManager::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber
    ];
});
