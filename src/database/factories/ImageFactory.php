<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Binder;
use App\Models\Image;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'binder_id' => function() {
            return factory(Binder::class)->create()->id;
        },
        'upload_user_id' => function() {
            return factory(User::class)->create()->id;
        },
        'name' => $faker->name,
        'sort' => 1,
        'visible' => config('_const.IMAGE.VISIBLE.SHOW'),
        'extension' => 'jpg'
    ];
});
