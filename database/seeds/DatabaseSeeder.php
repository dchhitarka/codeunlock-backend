<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 3)->create();
        factory(App\models\Post::class, 10)->create();
        factory(App\models\Comment::class,5)->create();
    }
}
