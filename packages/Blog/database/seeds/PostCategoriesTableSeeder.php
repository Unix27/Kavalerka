<?php

namespace Blog\database\seeds;

use Blog\Models\BlogCategory;
use Illuminate\Database\Seeder;

class PostCategoriesTableSeeder extends Seeder
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
                "title" => "Продвижение и реклама",
                "slug" => "advertising",
            ],
            [
                "title" => "Статистика и аналитика",
                "slug" => "statistics-and-analytics",
            ],
            [
                "title" => "Инструкции",
                "slug" => "instructions",
            ],
        ];

        foreach ($data as $category) {
            $model = new BlogCategory();

            $model->translateOrNew('ru')->fill($category);

            $model->save();
        }

    }
}
