<?php

use Faker\Generator as Faker;

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

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'uuid' => $faker->uuid,
        'username' => $faker->userName,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('s3cr3t'),
        'remember_token' => str_random(10),
        'api_token' => str_random(60),
        'verified' => true,
        'active' => true
    ];
});
