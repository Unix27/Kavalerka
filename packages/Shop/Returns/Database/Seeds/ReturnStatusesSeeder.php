<?php

namespace Shop\Returns\Database\Seeds;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;
use Shop\Returns\Models\ReturnStatuses as Model;

class ReturnStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = Model::create([
            "name" => 'Открыт',
        ]);

        $model->save();

        $model = Model::create([
            "name" => 'Закрыт',
        ]);

        $model->save();
    }
}
