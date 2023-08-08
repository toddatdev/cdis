<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Project\ProjectReview;
use Faker\Generator as Faker;

$factory->define(ProjectReview::class, function (Faker $faker) {
    return [

        'is_admin' => (int)$faker->boolean,
        'review_date' => $faker->date('d/m/Y'),
        'admin_status' => $faker->randomElement(['complete', 'incomplete']),
        'admin_initials' => $faker->countryCode,
//        'reviewed' => $faker->,
        'tech_status' => $faker->randomElement(['On Duty', 'On Leave', 'On Site']),
        'tech_initials' => $faker->countryCode,
        'return_reason' => substr($faker->text, 0, 100),
        'date_withdrawn' => $faker->date('d/m/Y')
    ];
});
