<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Binder;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Binder::class, function (Faker $faker) {
    return [
        'create_user_id' => function() {
            return factory(User::class)->create()->id;
        },
        'name' => $faker->name,
    ];
});
