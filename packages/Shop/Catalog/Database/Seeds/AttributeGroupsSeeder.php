<?php

namespace Shop\Catalog\Database\Seeds;

use Illuminate\Database\Seeder;
use Shop\Catalog\Models\AttributeGroup as Model;

class AttributeGroupsSeeder extends Seeder
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
                    'code' => 'cpu'
                ],
                'translations' => [
                    'ru' => [
                        'title' => 'Производительность'
                    ]
                ]

            ],
            [
                'common' => [
                    'code' => 'shield'
                ],
                'translations' => [
                    'ru' => [
                        'title' => 'Корпус'
                    ]
                ]
            ],
            [
                'common' => [
                    'code' => 'screen'
                ],
                'translations' => [
                    'ru' => [
                        'title' => 'Экран'
                    ]
                ]
            ],
        ];

        foreach ($data as $options) {
            $model = Model::create($options['common']);

            foreach ($options['translations'] as $locale => $translation)
            $model->translateOrNew($locale)->fill($translation);
            $model->save();
        }
    }
}
