<?php

//$admin_path = setting('admin_path');
$admin_path = env('ADMIN_PATH');

return [
    [
        'section' => 'Магазин',
        'sort' => 700,
    ],
    [
        'title' => 'Каталог',
        'root' => true,
        'icon' => 'media/svg/icons/Shopping/Cart3.svg',
        'new-tab' => false,
        'sort' => 702,
        'bullet' => 'dot',
        'submenu' => [
            [
                'title' => 'Товары',
                'page' => "$admin_path/shop/catalog/products",
            ],
            [
                'title' => 'Категории',
                'page' => "$admin_path/shop/catalog/categories",
            ],
            [
                'title' => 'Атрибуты',
                'bullet' => 'dot',
                'submenu' => [
                    [
                        'title' => 'Атрибуты',
                        'page' => "$admin_path/shop/catalog/attributes",
                    ],
//                    [
//                        'title' => 'Группы атрибутов',
//                        'page' => "$admin_path/shop/catalog/attribute_groups",
//                    ],
                ]

            ],
            [
                'title' => 'Бренды',
                'page' => "$admin_path/shop/catalog/brands",
            ],
						[
								'title' => 'Акции',
								'page'  => "$admin_path/shop/catalog/promotions",
						],
        ],

    ],
    [
        'title' => 'Отзывы',
        'root' => true,
        'icon' => 'media/svg/icons/Communication/Chat4.svg',
        'new-tab' => false,
        'page' => "$admin_path/shop/catalog/reviews",
        'sort' => 703,
    ],


];
