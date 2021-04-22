<?php

namespace Admin\database\seeds;

use DB;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
                [
                    'name' => 'admin',
                    'login' => 'admin',
                    'email' => 'admin@admin.com',
                    'password' => bcrypt('password'),
                    //'google2fa_secret' => 'VHXZYBLBUNA6ANHO'
                ],
                [
                    'name' => 'dev',
                    'login' => 'dev',
                    'email' => 'dev@admin.com',
                    'password' => bcrypt('QAZwsx123'),
                    //'google2fa_secret' => 'VHXZYBLBUNA6ANHO'
                ],
            ]
        );
    }
}
