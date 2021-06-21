<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'birthdate' => '11-02-1994',
        'address' => 'brakenburghstraat',
        'zip_code' => '1111AA',
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('secret'), // password
        'remember_token' => Str::random(10),
    ];
});
