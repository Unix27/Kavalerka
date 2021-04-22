<?php

namespace Shop\Returns\Database\Seeds;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;
use Shop\Returns\Models\ReturnReasons as Model;

class ReturnReasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = Model::create([
            "name" => 'Неисправность, пожалуйста, предоставьте информацию',
        ]);

        $model->save();

        $model = Model::create([
            "name" => 'Ошибка заказа',
        ]);

        $model->save();

        $model = Model::create([
            "name" => 'Получен неверный предмет',
        ]);

        $model->save();
    }
}
