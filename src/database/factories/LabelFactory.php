<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Binder;
use App\Models\Label;
use Faker\Generator as Faker;

$factory->define(Label::class, function (Faker $faker) {
    return [
        'binder_id' => function() {
            return factory(Binder::class)->create()->id;
        },
        'name' => $faker->name,
        'sort' => 1,
    ];
});
