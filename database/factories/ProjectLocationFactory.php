<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Project\ProjectLocation;
use Faker\Generator as Faker;

$factory->define(ProjectLocation::class, function (Faker $faker) {
    return [
        'address_1' => $faker->address,
        'address_2' => $faker->address,
        'city' => $faker->city,
        'zipcode' => $faker->postcode,
        'lat_deg' => $faker->numberBetween(0, 10),
        'lat_min' => $faker->numberBetween(0, 10),
        'lat_sec' => $faker->numberBetween(0, 10),
        'long_deg' => $faker->numberBetween(0, 10),
        'long_min' => $faker->numberBetween(0, 10),
        'long_sec' => $faker->numberBetween(0, 10)
    ];
});
