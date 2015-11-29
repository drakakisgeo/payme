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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Payment::class, function (Faker\Generator $faker) {
    return [
      'description' => $faker->sentence(),
      'amount' => $faker->randomFloat(2,10,100),
      'user_id' => array_rand(App\User::lists('id','id')->toArray()),
      'code' => \Rhumsaa\Uuid\Uuid::uuid4()->toString(),
      'active'=> 1,
      'paid'=>0,
      'invoiced'=>0,
      'paid_at'=>null
    ];
});
