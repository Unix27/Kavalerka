<?php

namespace Blog\database\seeds;

use Blog\database\seeds\PostCategoriesTableSeeder;
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
        $this->call(PostCategoriesTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(BlogPermissionsSeeder::class);
    }
}
