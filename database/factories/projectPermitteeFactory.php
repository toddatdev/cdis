<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Http\Helper\Helper;
use App\Model;
use App\Models\Project\ProjectPermittee;
use Faker\Generator as Faker;

$factory->define(ProjectPermittee::class, function (Faker $faker) {

    $states = array_keys(Helper::get_states_options());

    return [
        'name' => $faker->name,
        'company' => $faker->company,
        'address_1' => $faker->address,
        'address_2' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->randomElement($states),
        'zipcode' => $faker->postcode,
        'phone' => substr($faker->phoneNumber, 0, 11),
        'fax' => substr($faker->phoneNumber, 0, 11),
        'received_date' => $faker->date('d/m/Y'),
        'reviewed_date' => $faker->date('d/m/Y'),
        'acknowledged' => (int)$faker->boolean,
        'email' => $faker->email
    ];
});
