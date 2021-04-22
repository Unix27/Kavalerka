<?php

namespace Pages\database\seeds;

use Blog\Models\BlogPost;
use Blog\Models\BlogPostTranslation;
use DB;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Pages\Models\Page;
use Pages\Models\PageTranslation;

class PagesSeeder extends Seeder
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
                "name" => "Юридическая информация",
                "slug" => "privacy-policy",
                "content" => __DIR__ . '/policy.json'
            ],
        ];

        foreach ($data as $page) {
            $model = new Page();
            $model->name = $page['name'];
            $model->slug = $page['slug'];
            $model->save();

            $translation = new PageTranslation();
            $translation->page_id = $model->id;
            $translation->title = $model->name;
            $translation->content = json_decode(file_get_contents($page['content']));
            $translation->locale = 'ru';
            $translation->save();
        }
    }
}
