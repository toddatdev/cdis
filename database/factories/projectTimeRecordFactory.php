<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Http\Helper\Helper;
use App\Model;
use App\Models\Project\ProjectTime;
use App\Models\Reviewer\Reviewer;
use App\User;
use Faker\Generator as Faker;

$factory->define(ProjectTime::class, function (Faker $faker) {

    $reviewers = Reviewer::where('id', '>', 0)->pluck('id')->toArray();
    $time_categories = Helper::get_time_categories_options();
    $users = User::where('id', '>', 0)->pluck('id')->toArray();

    return [
        'reviewer_id' => $faker->randomElement($reviewers),
        'user_id' => $faker->randomElement($users),
        'time_category' => $faker->randomElement($time_categories),
        'hours' => $faker->numberBetween(3, 100),
        'submit_type' => $faker->randomElement(['new', 'resubmit']),
        'date' => $faker->date('d/m/Y'),
    ];
});
