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
// 主要用来生成一些假数据

$factory->define( App\Models\User::class, function (Faker $faker) {
    $date_time = $faker->date.' '.$faker->time;
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'is_admin' => false,
        'activated' => true,
        'created_at' => $date_time,
        'updated_at' => $date_time
    ];
});