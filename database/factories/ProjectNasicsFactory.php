<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Project\ProjectDetailNasics;
use Faker\Generator as Faker;

$factory->define(ProjectDetailNasics::class, function (Faker $faker) {
    return [
        'id' => 1,
        'nasic' => $faker->text(20)
    ];
});
