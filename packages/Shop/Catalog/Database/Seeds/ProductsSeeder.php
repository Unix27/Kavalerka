<?php

namespace Shop\Catalog\Database\Seeds;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;
use Shop\Catalog\Models\Product as Model;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $model = Model::create([
                "sku" => Uuid::uuid4(),
                "price" => mt_rand(1, 1000),
                "image" => asset('/assets/img/png/card/photo.png')
            ]);

            $model->translateOrNew('ru')->fill([
                'title' => $faker->name,
                'slug' => $faker->slug,
                'description' => $faker->text,
            ]);


            $model->save();
        }
    }
}
