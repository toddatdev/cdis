<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Project\ProjectPermit;
use Faker\Generator as Faker;

$factory->define(ProjectPermit::class, function (Faker $faker) {
    return [
        'npdes_number' => strtoupper(substr($faker->sha1, 0, 6)),
        'received_date' => $faker->date('m/d/Y'),
        'pindi_date' => $faker->date('m/d/Y'),
        'final_inspection_date' => $faker->date('m/d/Y'),
        'permit_complete_date' => $faker->date('m/d/Y'),
        'permit_issued_date' => $faker->date('m/d/Y'),
        'permit_expiration_date' => $faker->date('m/d/Y'),
        'is_notice_received' => (int)$faker->boolean,
        'notice_received_date' => $faker->date('m/d/Y'),
        'is_notice_acknowledged' => (int)$faker->boolean,
        'is_active' => (int)$faker->boolean
    ];
});
