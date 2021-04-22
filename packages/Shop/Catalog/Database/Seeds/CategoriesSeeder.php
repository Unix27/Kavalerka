<?php

namespace Shop\Catalog\Database\Seeds;

use Illuminate\Database\Seeder;
use Shop\Catalog\Models\Category as Model;

class CategoriesSeeder extends Seeder
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
                    'status_id' => 1,
                    'show_menu' => true,
                    'show_catalog' => true,
                    'image' => asset('assets/img/svg/icons-miniland/Стратвовые наборы.svg')
                ],
                'child' => [
                    [
                        'common' => [
                            'status_id' => 1,
                            'show_menu' => true,
                            'show_catalog' => true,
                        ],
                        'translations' => [
                            'ru' => [
                                'title' => 'Локомотив',
                                'slug' => 'locomotive',
                                'description' => 'Тестовое описание категории',
                            ]
                        ],
                          'child' => [
                            [
                                'common' => [
                                    'status_id' => 1,
                                    'show_menu' => true,
                                    'show_catalog' => true,
                                ],
                                'translations' => [
                                    'ru' => [
                                        'title' => 'Локомотив',
                                        'slug' => 'locomotive3',
                                        'description' => 'Тестовое описание категории',
                                    ]
                                ]
                            ],
                            [
                                'common' => [
                                    'status_id' => 1,
                                    'show_menu' => true,
                                    'show_catalog' => true,
                                ],
                                'translations' => [
                                    'ru' => [
                                        'title' => 'Подвижной состав',
                                        'slug' => 'rolling-stock2',
                                        'description' => 'Тестовое описание категории',
                                    ]
                                ]
                            ],
                        ],
                    ],

                    [
                        'common' => [
                            'status_id' => 1,
                            'show_menu' => true,
                            'show_catalog' => true,
                        ],
                        'translations' => [
                            'ru' => [
                                'title' => 'Локомотив',
                                'slug' => 'locomotive2',
                                'description' => 'Тестовое описание категории',
                            ]
                        ]
                    ]
                ],
                'translations' => [
                    'ru' => [
                        'title' => 'Стартовые наборы',
                        'slug' => 'starter-kits',
                        'description' => 'Тестовое описание категории',
                    ]
                ]
            ],[
                'common' => [
                    'status_id' => 1,
                    'show_menu' => true,
                    'show_catalog' => true,
                    'image' => asset('assets/img/svg/icons-miniland/Подвижный состав.svg')
                ],
                'translations' => [
                    'ru' => [
                        'title' => 'Подвижной состав',
                        'slug' => 'rolling-stock',
                        'description' => 'Тестовое описание категории',
                    ]
                ]
            ],[
                'common' => [
                    'status_id' => 1,
                    'show_menu' => true,
                    'show_catalog' => true,
                    'image' => asset('assets/img/svg/icons-miniland/Рельсовый.svg')
                ],
                'translations' => [
                    'ru' => [
                        'title' => 'Рельсовый материал',
                        'slug' => 'rail-material',
                        'description' => 'Тестовое описание категории',
                    ]
                ]
            ],
            [
                'common' => [
                    'status_id' => 1,
                    'show_menu' => true,
                    'show_catalog' => true,
                    'image' => asset('assets/img/svg/icons-miniland/Строения.svg')
                ],
                'translations' => [
                    'ru' => [
                        'title' => 'Строения',
                        'slug' => 'buildings',
                        'description' => 'Тестовое описание категории',
                    ]
                ]
            ],
            [
                'common' => [
                    'status_id' => 1,
                    'show_menu' => true,
                    'show_catalog' => true,
                    'image' => asset('assets/img/svg/icons-miniland/Транспортные.svg')
                ],
                'translations' => [
                    'ru' => [
                        'title' => 'Транспортные средства',
                        'slug' => 'vehicles',
                        'description' => 'Тестовое описание категории',
                    ]
                ]
            ],
            [
                'common' => [
                    'status_id' => 1,
                    'show_menu' => true,
                    'show_catalog' => true,
                    'image' => asset('assets/img/svg/icons-miniland/Аксессуары.svg')
                ],
                'translations' => [
                    'ru' => [
                        'title' => 'Аксессуары',
                        'slug' => 'accessories',
                        'description' => 'Тестовое описание категории',
                    ]
                ]
            ],
            [
                'common' => [
                    'status_id' => 1,
                    'show_menu' => true,
                    'show_catalog' => true,
                    'image' => asset('assets/img/svg/icons-miniland/Инструметы.svg')
                ],
                'translations' => [
                    'ru' => [
                        'title' => 'Инструмент',
                        'slug' => 'tool',
                        'description' => 'Тестовое описание категории',
                    ]
                ]
            ],
            [
                'common' => [
                    'status_id' => 1,
                    'show_menu' => true,
                    'show_catalog' => true,
                    'image' => asset('assets/img/svg/icons-miniland/Управление.svg')
                ],
                'translations' => [
                    'ru' => [
                        'title' => 'Управление/Электроника',
                        'slug' => 'сontrol-electronics',
                        'description' => 'Тестовое описание категории',
                    ]
                ]
            ],
            [
                'common' => [
                    'status_id' => 1,
                    'show_menu' => true,
                    'show_catalog' => true,
                    'image' => asset('assets/img/svg/icons-miniland/Декор.svg')
                ],
                'translations' => [
                    'ru' => [
                        'title' => 'Декор',
                        'slug' => 'decor',
                        'description' => 'Тестовое описание категории',
                    ]
                ]
            ],

        ];

        foreach ($data as $options) {
            $model = Model::create($options['common']);

            foreach ($options['translations'] as $locale => $translation) {
                $model->translateOrNew($locale)->fill($translation);
            }

            if(isset($options['child'])){
                foreach($options['child'] as $child){

                    $child['common']['parent_id'] = $model->id;
                    $model2 = Model::create($child['common']);

                    foreach ($child['translations'] as $locale => $translation) {
                        $model2->translateOrNew($locale)->fill($translation);
                    }
                    $model2->save();

                    if(isset($child['child'])){
                        foreach($child['child'] as $ch){
                            $ch['common']['parent_id'] = $model2->id;
                            $model3 = Model::create($ch['common']);
                            foreach ($ch['translations'] as $locale => $translation) {
                                $model3->translateOrNew($locale)->fill($translation);
                            }
                            $model3->save();

                        }
                    }


                }
            }

            $model->save();
        }
    }
}
