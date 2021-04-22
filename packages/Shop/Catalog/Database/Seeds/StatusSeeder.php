<?php

namespace Shop\Catalog\Database\Seeds;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;
use Shop\Catalog\Models\Status as Model;
use Shop\Catalog\Models\ShopStatus;


class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = Model::create([
            "name" => 'Активная',
        ]);

        $model->save();

        $model = Model::create([
            "name" => 'Неактивная',
        ]);

        $model->save();


        $model = ShopStatus::create([
            "name" => 'Черновик',
        ]);

        $model->save();

        $model = ShopStatus::create([
            "name" => 'Опубликован',
        ]);

        $model->save();



    }
}
