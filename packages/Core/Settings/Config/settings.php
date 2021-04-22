<?php

return [

    // All the sections for the settings page
    'sections' => [
        'app' => [
            'title' => 'Основные настройки',
            'descriptions' => '',
            'icon' => 'media/svg/icons/General/Settings-2.svg',

            'inputs' => [
                [
                    'name' => 'site_name',
                    'type' => 'text',
                    'label' => 'Название сайта',
                    'value' => config('app.name'),
                    'locale_based' => true,
                ],
                [
                    'name' => 'email_admin',
                    'type' => 'email',
                    'label' => 'Email администратора',
                    'value' => 'alex142970@gmail.com'
                ],
                [
                    'name' => 'email_support',
                    'type' => 'email',
                    'label' => 'Email техподдержки',
                    'value' => 'support@test.com'
                ],
                [
                    'name' => 'currency',
                    'type' => 'text',
                    'label' => 'Валюта (символ)',
                    'value' => 'грн.'
                ],
            ]
        ],
        'seo' => [
            'title' => 'SEO',
            'descriptions' => '', // (optional)
            'icon' => 'media/svg/icons/General/Settings-1.svg', // (optional)

            'inputs' => [
                [
                    'heading' => 'Главная страница:'
                ],
                [
                    'name' => 'main_page_meta_title',
                    'type' => 'text',
                    'label' => 'Meta title',
                    'locale_based' => true,
                ],
                [
                    'name' => 'main_page_meta_description',
                    'type' => 'textarea',
                    'label' => 'Meta description',
                    'locale_based' => true,
                ],
                [
                    'name' => 'main_page_meta_keywords',
                    'type' => 'textarea',
                    'label' => 'Meta keywords',
                    'locale_based' => true,
                ],
                [
                    'name' => 'main_page_post_content',
                    'type' => 'editor',
                    'label' => 'Текст перед футером',
                    'locale_based' => true,
                ],

                ['separator' => true],

                [
                    'heading' => 'Страница блога:'
                ],
                [
                    'name' => 'blog_page_heading',
                    'type' => 'text',
                    'label' => 'Заголовок',
                    'value' => 'Блог',
                    'locale_based' => true,
                ],
                [
                    'name' => 'blog_page_meta_title',
                    'type' => 'text',
                    'label' => 'Meta title',
                    'locale_based' => true,
                ],
                [
                    'name' => 'blog_page_meta_description',
                    'type' => 'textarea',
                    'label' => 'Meta description',
                    'locale_based' => true,
                ],
                [
                    'name' => 'blog_page_meta_keywords',
                    'type' => 'textarea',
                    'label' => 'Meta keywords',
                    'locale_based' => true,
                ],
                [
                    'name' => 'blog_page_post_content',
                    'type' => 'editor',
                    'label' => 'Текст перед футером',
                    'locale_based' => true,
                ],
            ]
        ],
//        'discounts' => [
//            'title' => 'Cкидки на товары',
//            'descriptions' => 'В разработке',
//            'icon' => 'media/svg/icons/General/Settings-2.svg',
//        ],
//        'recall' => [
//            'title' => 'Обратная связь',
//            'descriptions' => 'В разработке',
//            'icon' => 'media/svg/icons/General/Settings-2.svg',
//        ],
//        'currency' => [
//            'title' => 'Валбты',
//            'descriptions' => 'В разработке',
//            'icon' => 'media/svg/icons/General/Settings-2.svg',
//        ],
//        'country' => [
//            'title' => 'Cтраны',
//            'descriptions' => 'В разработке',
//            'icon' => 'media/svg/icons/General/Settings-2.svg',
//        ],
//        'taxes' => [
//            'title' => 'Налоги',
//            'descriptions' => 'В разработке',
//            'icon' => 'media/svg/icons/General/Settings-2.svg',
//        ],
//        'warehouse' => [
//            'title' => 'Склад',
//            'descriptions' => 'В разработке',
//            'icon' => 'media/svg/icons/General/Settings-2.svg',
//        ],
//        'units_of_measure' => [
//            'title' => 'Единицы измерения',
//            'descriptions' => 'В разработке',
//            'icon' => 'media/svg/icons/General/Settings-2.svg',
//        ],
//        'weight' => [
//            'title' => 'Вес',
//            'descriptions' => 'В разработке',
//            'icon' => 'media/svg/icons/General/Settings-2.svg',
//        ]
    ],


    // Remove any setting which declaration removed later from sections
    'remove_abandoned_settings' => false,


    // settings group
    'setting_group' => function() {
        // return 'user_'.auth()->id();
        return 'default';
    }
];
