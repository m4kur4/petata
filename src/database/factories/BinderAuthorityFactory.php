<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Binder;
use App\Models\User;
use App\Models\BinderAuthority;
use Faker\Generator as Faker;

$factory->define(BinderAuthority::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(User::class)->create()->id;
        },
        'binder_id' => function() {
            return factory(Binder::class)->create()->id;
        },
        'level' => config('_const.BINDER_AUTHORITY.LEVEL.GUEST')
    ];
});
