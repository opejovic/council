<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Thread;
use App\Models\Reply;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'thread_id' => function () {
            return factory(Thread::class)->create()->id;
        },
        'body' => $faker->realText($maxchars = 100)
    ];
});
