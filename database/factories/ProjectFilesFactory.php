<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\ProjectFile;
use Faker\Generator as Faker;

$factory->define(ProjectFile::class, function (Faker $faker) {
    return [
        'path' => 'file.pdf',
        'name' => $faker->company . '.pdf',
        'memo' => $faker->text,
        'creator_id' => 3
    ];
});
