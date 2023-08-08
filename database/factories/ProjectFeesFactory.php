<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Http\Helper\Helper;
use App\Model;
use App\Models\Project\ProjectFee;
use Faker\Generator as Faker;

$factory->define(ProjectFee::class, function (Faker $faker) {

    $fee_types = array_keys(Helper::get_fee_type_options());

    return [
        'is_admin' => (int)$faker->boolean,
        'submission_type' => $faker->randomElement(['New', 'Resubmit']),
        'review_number' => strtoupper(substr($faker->sha1, 0, 6)),
        'disturbed_acres' => $faker->numberBetween(1, 49),
        'total_acres' => $faker->numberBetween(50, 100),
        'fee_type' => $faker->randomElement($fee_types),
        'fee_amount' => $faker->numberBetween(3000, 10000),
        'check_number' => strtoupper(substr($faker->sha1, 0, 10)),
        'payer_name' => $faker->name,
        'check_date' => $faker->date('m/d/Y')
    ];
});
