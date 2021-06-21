<?php

use Faker\Generator as Faker;
use App\Announcement;

$factory->define(Announcement::class, function (Faker $faker) {
    return [
        'course_id' => $faker->numberBetween($min = 1, $max = 3),
        'announcement' => $faker->paragraphs($nb = 3, $asText = true)
    ];
});
