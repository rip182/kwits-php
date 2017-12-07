<?php

use Faker\Generator as Faker;

$factory->define(App\Expense::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'amount' => $faker->randomFloat(null, 100, 5000)
    ];
});
