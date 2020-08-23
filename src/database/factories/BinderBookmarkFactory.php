<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Binder;
use App\Models\User;
use App\Models\BinderFavorite;
use Faker\Generator as Faker;

$factory->define(BinderFavorite::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(User::class)->create()->id;
        },
        'binder_id' => function() {
            return factory(Binder::class)->create()->id;
        },
    ];
});
