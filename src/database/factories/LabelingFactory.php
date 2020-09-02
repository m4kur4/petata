<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Image;
use App\Models\Label;
use App\Models\Labeling;
use Faker\Generator as Faker;

$factory->define(Labeling::class, function (Faker $faker) {
    return [
        'label_id' => function() {
            return factory(Label::class)->create()->id;
        },
        'image_id' => function() {
            return factory(Image::class)->create()->id;
        },
        
    ];
});
