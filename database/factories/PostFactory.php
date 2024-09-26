<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Post;
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

$factory->define(Post::class, function (Faker $faker) {
    return [
        'post_title' => $faker->unique()->name,
        'post_body' => $faker->paragraph,
        'user_id' => factory(App\User::class),
        'post_likes' => $faker->randomDigit,
        'post_bookmarks' => $faker->randomDigit,
    ];
});
