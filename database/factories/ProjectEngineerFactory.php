<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Http\Helper\Helper;
use App\Model;
use App\Models\Project\ProjectEngineer;
use Faker\Generator as Faker;

$factory->define(ProjectEngineer::class, function (Faker $faker) {

    $states = array_keys(Helper::get_states_options());

    return [
        'name' => $faker->name,
        'company_name' => $faker->company,
        'address_1' => $faker->address,
        'address_2' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->randomElement($states),
        'zipcode' => $faker->postcode,
        'phone_number' => $faker->phoneNumber,
        'phone_number_ext' => $faker->phoneNumber,
        'fax_number' => $faker->phoneNumber,
        'email' => $faker->email
    ];
});
