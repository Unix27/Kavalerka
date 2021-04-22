<?php

namespace Shop\Catalog\Database\Seeds;

use Illuminate\Database\Seeder;
use Shop\Catalog\Models\Attribute as Model;

class AttributesSeeder extends Seeder
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
                'common' => [
                    'attribute_group_id' => 1,
                    'active' => true,
                    'use_filter' => true,
                ],
                'translations' => [
                    'ru' => [
                        'title' => 'Частота процессора',
                        'description' => 'Тестовое описание атрибута',
                    ]
                ]
            ],[
                'common' => [
                    'attribute_group_id' => 1,
                    'active' => true,
                    'use_filter' => true,
                ],
                'translations' => [
                    'ru' => [
                        'title' => 'Оперативная память',
                        'description' => 'Тестовое описание атрибута',
                    ]
                ]
            ],[
                'common' => [
                    'attribute_group_id' => 1,
                    'active' => true,
                    'use_filter' => true,
                ],
                'translations' => [
                    'ru' => [
                        'title' => 'Разрешение экрана',
                        'description' => 'Тестовое описание атрибута',
                    ]
                ]
            ],[
                'common' => [
                    'attribute_group_id' => 1,
                    'active' => true,
                    'use_filter' => true,
                ],
                'translations' => [
                    'ru' => [
                        'title' => 'Диагональ экрана',
                        'description' => 'Тестовое описание атрибута',
                    ]
                ]
            ],
        ];

        foreach ($data as $options) {
            $model = Model::create($options['common']);

            foreach ($options['translations'] as $locale => $translation) {
                $model->translateOrNew($locale)->fill($translation);
            }

            $model->save();
        }
    }
}
