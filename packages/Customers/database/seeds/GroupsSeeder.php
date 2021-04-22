<?php

namespace Customers\database\seeds;

use Blog\Models\BlogCategory;
use Blog\Models\BlogCategoryTranslation;
use Customers\Models\CustomerGroup;
use DB;
use Illuminate\Database\Seeder;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            [
                "name" => "По умолчанию",
            ],
        ];

        foreach ($data as $group) {
            $model = new CustomerGroup();
            $model->fill($group);
            $model->save();
        }
    }
}
