<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Comment;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'comment_body' => $faker->paragraph,
        'user_id' => factory(App\User::class),
        'comment_likes' => $faker->randomDigit,
        'post_id' => factory(App\models\Post::class),
    ];
});
