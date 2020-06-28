<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Thread;
use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'category_id' => function () {
            return factory(Category::class)->create()->id;
        },
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'title' => $faker->sentence($words = 3),
        'body' => $faker->realText($maxChars = 300)
    ];
});
