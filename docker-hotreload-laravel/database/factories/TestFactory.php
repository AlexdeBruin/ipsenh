<?php
use App\Test;
use Faker\Generator as Faker;

$factory->define(Test::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'course_id' => $faker->numberBetween($min = 1, $max = 3),
        'percentage' => $faker->numberBetween($min = 10, $max = 60),
        'mandatory' => $faker->boolean($changeOfGettingTrue = 90),
        'semester' => $faker->numberBetween($min = 1, $max = 4),
        'grades_inserted' => 0,
        'given_at' => $faker->dateTimeBetween($startDate = '-20 days', $endDate = 'now', $timezone = null),
        'retake' => $faker->boolean($chanceOfGettingTrue = 10)
    ];
});

