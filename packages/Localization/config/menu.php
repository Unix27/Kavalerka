<?php

return [
    [
        'title' => 'Локализация',
        'root' => true,
        'icon' => 'fas fa-language',
        'new-tab' => false,
        'sort' => 1003,
        'bullet' => 'dot',
        'submenu' => [
            [
                'title' => 'Языки',
                'page' => 'admin/localization/locales',
            ],
            [
                'title' => 'Переводы',
                'page' => 'admin/localization/manager',
            ],
        ],
    ],


];
