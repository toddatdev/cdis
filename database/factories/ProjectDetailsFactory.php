<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Http\Helper\Helper;
use App\Model;
use App\Models\County\County;
use App\Models\Project\ProjectDetail;
use App\Models\Reviewer\Reviewer;
use Faker\Generator as Faker;

$factory->define(ProjectDetail::class, function (Faker $faker) {

    $reviewers = Reviewer::where('id', '>', 0)->pluck('id')->toArray();
    $counties = County::where('id', '>', 0)->pluck('id')->toArray();

    $municipalities = array_keys(Helper::get_municipalities_opts());
    $ownerships = array_keys(Helper::get_ownership_opts());

    return [
        'reviewer_id' => $faker->randomElement($reviewers),
        'municipality' => $faker->randomElement($municipalities),
        'county_id' => $faker->randomElement($counties),
        'tax_parcel' => $faker->creditCardType,
        'watershed' => $faker->userName,
        'receiving_stream' => $faker->city,
        'plan_date' => $faker->date('m/d/Y'),
        'ownership' => $faker->randomElement($ownerships),
        'ch_93_class' => $faker->domainWord,
        'total_acres' => random_int(50, 100),
        'disturbed_acres' => random_int(1, 49)
    ];
});
