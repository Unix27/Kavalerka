<?php

namespace Shop\Catalog\Database\Seeds;

use Blog\Models\BlogPost;
use Blog\Models\BlogPostTranslation;
use DB;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Shop\Catalog\Models\AttributeGroup;
use Shop\Catalog\Models\Brand;
use Shop\Catalog\Models\Category;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $locale = 'ru';
        $faker = Factory::create();

        $attributes = [
            'active' => true,
        ];

        for($i = 0; $i < 10; $i++) {
            $brand = Brand::create($attributes);
            $brand->translateOrNew($locale)->fill([
                'title' => $faker->company,
                'description' => 'Тестовое описание производителя',
            ]);
            $brand->save();
        }
    }
}
