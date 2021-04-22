<?php

namespace Blog\database\seeds;

use DB;
use Illuminate\Database\Seeder;

class BlogPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_permissions')->insert(
            [
                [
                    'name' => 'Показывать страницу блога',
                    'slug' => 'blog.view',
                ],
                [
                    'name' => 'Создание постов',
                    'slug' => 'blog.create_post',
                ],
                [
                    'name' => 'Изменение постов',
                    'slug' => 'blog.edit_post',
                ],
                [
                    'name' => 'Удаление постов',
                    'slug' => 'blog.delete_post',
                ],
            ]
        );
    }
}
