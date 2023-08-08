<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\County\County;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => 'Todd',
        'last_name' => 'Cutick',
        'email' => 'todd@gmail.com',
        'username' => 'toddcutick01',
        'icis_username' => 'icistcutick',
//        'first_name' => $faker->firstName,
//        'last_name' => $faker->lastName,
//        'username' => $faker->userName,
//        'icis_username' => $faker->userName,
//        'email' => $faker->email,
        'county_id' => $faker->randomElement(County::pluck('id')),
        'role' => 'Business Manager',
        'is_logged_in' => (integer)$faker->boolean,
        'is_active' => (integer)$faker->boolean,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});
