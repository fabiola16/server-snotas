<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

// User
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text(rand(32, 10)),
        'user_name' => $faker->unique()->safeEmail,
        'email' => $faker->unique()->safeEmail,
        'password' => '123456',
        'api_token' => str_random(60)];
});

// Role
$factory->define(App\Role::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->text(rand(32, 10)),
        'role' => '1',
        'state' => 'ACTIVE',
    ];
});

// Professional
$factory->define(App\Professional::class, function (Faker\Generator $faker) {
    return [
        'identity' => str_random(10),
        'first_name' => str_random(10),
        'last_name' => str_random(10),
        'email' => $faker->unique()->safeEmail,
        'nationality' => str_random(10),
        'civil_state' => str_random(10),
        'birthdate' => '2018-10-01',
        'gender' => str_random(10),
        'phone' => str_random(10),
        'address' => str_random(10),
        'state' => str_random(10),
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});

// Language
$factory->define(App\Language::class, function (Faker\Generator $faker) {
    return [
        'description' => str_random(10),
        'written_level' => str_random(10),
        'spoken_level' => str_random(10),
        'reading_level' => $faker->unique()->safeEmail,
        'state' => str_random(10),
        'professional_id' => function () {
            return factory(App\Professional::class)->create()->id;
        }
    ];
});