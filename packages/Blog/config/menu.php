<?php

return [
    [
        'title' => 'Блог',
        'root' => true,
        'icon' => 'media/svg/icons/Home/Book-open.svg',
        'sort' => 200,
        'new-tab' => false,
        'bullet' => 'dot',
        'submenu' => [
            [
                'title' => 'Статьи',
                'page' => 'admin/blog/posts',
            ],
            [
                'title' => 'Категории',
                'page' => 'admin/blog/categories',
            ],
        ],
    ],
];
