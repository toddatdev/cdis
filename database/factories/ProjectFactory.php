<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Project\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {

    $types = ['individual', 'general', 'nonpermitted', 'inspection'];
    return [
        'name' => $faker->company,
        'is_active' => (int)$faker->boolean,
        'plan_type' => $faker->randomElement($types)
    ];
});
