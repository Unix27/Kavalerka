<?php

namespace Admin\database\seeds;

use DB;
use Illuminate\Database\Seeder;

class AdminRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('admin_roles')->insert(
            [
                'name' => 'Администратор',
                'slug' => 'admin'
            ]
        );

        DB::table('admin_roles')->insert(
            [
                'name' => 'Редактор',
                'slug' => 'editor'
            ]
        );

        DB::table('admin_roles')->insert(
            [
                'name' => 'Автор',
                'slug' => 'author'
            ]
        );

        DB::table('admin_roles')->insert(
            [
                'name' => 'Подписчик',
                'slug' => 'subscriber'
            ]
        );

        DB::table('admin_roles')->insert(
            [
                'name' => 'Пользователь',
                'slug' => 'user'
            ]
        );

//        DB::table('admin_roles_to_admins')->insert(
//            [
//                [
//                    'role_id' => 3,
//                    'admin_id' => 1
//                ],
//                [
//                    'role_id' => 3,
//                    'admin_id' => 2
//                ]
//            ]
//
//        );
    }
}
