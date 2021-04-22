<?php

namespace Admin\database\seeds;

use Admin\Models\AdminPermission;
use Admin\Models\AdminRole;
use DB;
use Illuminate\Database\Seeder;

class AdminPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role = AdminRole::where('slug', 'admin')->first();

        $permissions = array(
            [
                'name' => 'Управление Страницами',
                'slug' => 'settings.pages',
                'children' => [
                    [
                        'name' => 'Просмотр',
                        'slug' => 'settings.pages.show',
                        'url' => '/pages',
                    ],
                    [
                        'name' => 'Добавление',
                        'slug' => 'settings.pages.add',
                        'url' => '/pages/create',
                    ],
                    [
                        'name' => 'Изменение',
                        'slug' => 'settings.pages.edit',
                        'url' => '/pages/:id/edit',
                    ],
                    [
                        'name' => 'Удаление',
                        'slug' => 'settings.pages.delete',
                        'url' => '/pages/:id',
                    ],
                ]
            ],
            [
                'name' => 'Управление блогом',
                'slug' => 'settings.blog',
                'children' => [
                    [
                        'name' => 'Блог',
                        'slug' => 'settings.blog.blog',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.blog.blog.show',
                                'url' => '/blog/posts',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.blog.blog.add',
                                'url' => '/blog/posts/create',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.blog.blog.edit',
                                'url' => '/blog/posts/:id/edit',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.blog.blog.delete',
                                'url' => '/blog/posts/:id',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Категории',
                        'slug' => 'settings.blog.category',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.blog.category.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.blog.category.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.blog.category.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.blog.category.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Управление заказами',
                'slug' => 'settings.orders',
                'children' => [
                    [
                        'name' => 'Заказы',
                        'slug' => 'settings.orders.orders',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.orders.orders.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.orders.orders.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.orders.orders.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.orders.orders.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Возвраты',
                        'slug' => 'settings.orders.returns',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.orders.returns.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.orders.returns.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.orders.returns.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.orders.returns.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Управление клиентами',
                'slug' => 'settings.clients',
                'children' => [
                    [
                        'name' => 'Клиенты',
                        'slug' => 'settings.customers.customers',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.customers.customers.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.customers.customers.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.customers.customers.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.customers.customers.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Группы',
                        'slug' => 'settings.customers.groups',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.customers.groups.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.customers.groups.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.customers.groups.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.customers.groups.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Управление каталогом',
                'slug' => 'settings.catalog',
                'children' => [
                    [
                        'name' => 'Товары',
                        'slug' => 'settings.catalog.products',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.catalog.products.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.catalog.products.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.catalog.products.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.catalog.products.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Категории',
                        'slug' => 'settings.catalog.categories',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.catalog.categories.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.catalog.categories.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.catalog.categories.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.catalog.categories.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Атрибуты',
                        'slug' => 'settings.catalog.attributes',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.catalog.attributes.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.catalog.attributes.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.catalog.attributes.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.catalog.attributes.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Группа атрибутов',
                        'slug' => 'settings.catalog.groups_attributes',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.catalog.groups_attributes.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.catalog.groups_attributes.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.catalog.groups_attributes.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.catalog.groups_attributes.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Производители',
                        'slug' => 'settings.catalog.manufacturers',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.catalog.manufacturers.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.catalog.manufacturers.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.catalog.manufacturers.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.catalog.manufacturers.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Отзывы',
                'slug' => 'settings.reviews',
            ],

            [
                'name' => 'Настройки Администратора',
                'slug' => 'settings.permissions',
                'children' => [
                    [
                        'name' => 'Роли',
                        'slug' => 'settings.permissions.roles',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.permissions.roles.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.permissions.roles.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.permissions.roles.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.permissions.roles.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Настройки',
                'slug' => 'settings.management',
                'children' => [
                    [
                        'name' => 'Основные настройки',
                        'slug' => 'settings.management.settings',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.management.settings.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.management.settings.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.management.settings.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.management.settings.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Валюты',
                        'slug' => 'settings.management.currency',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.management.currency.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.management.currency.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.management.currency.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.management.currency.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Склад',
                        'slug' => 'settings.management.storage',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.management.storage.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.management.storage.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.management.storage.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.management.storage.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Единицы измерения',
                        'slug' => 'settings.management.units',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.management.units.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.management.units.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.management.units.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.management.units.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Единицы веса',
                        'slug' => 'settings.management.weight',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.management.weight.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.management.weight.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.management.weight.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.management.weight.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Статусы возврата',
                        'slug' => 'settings.management.return_statuses',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.management.return_statuses.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.management.return_statuses.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.management.return_statuses.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.management.return_statuses.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Причины возврата',
                        'slug' => 'settings.management.return_reasons',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.management.return_reasons.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.management.return_reasons.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.management.return_reasons.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.management.return_reasons.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Настройки Локализации',
                'slug' => 'settings.localization',
                'children' => [
                    [
                        'name' => 'Локализация',
                        'slug' => 'settings.localization.locales',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.localization.locales.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.localization.locales.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.localization.locales.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.localization.locales.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ],
                    [
                        'name' => 'translations',
                        'slug' => 'settings.localization.translations',
                        'children' => [
                            [
                                'name' => 'Просмотр',
                                'slug' => 'settings.localization.translations.show',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Добавление',
                                'slug' => 'settings.localization.translations.add',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Изменение',
                                'slug' => 'settings.localization.translations.edit',
                                'url' => '/pages/:id',
                            ],
                            [
                                'name' => 'Удаление',
                                'slug' => 'settings.localization.translations.delete',
                                'url' => '/pages/:id',
                            ],
                        ]
                    ],
                ]
            ],

        );

        foreach ($permissions as $permission) {
            $permissionModel = new AdminPermission();
            $permissionModel->fill([
                'name' => $permission['name'],
                'slug' => $permission['slug']
            ]);
            $permissionModel->save();
            $role->permissions()->attach($permissionModel->id);

            if(isset($permission['children'])) {
                foreach ($permission['children'] as $item) {
                    $dopPermissionModel = new AdminPermission();

                    $args = [
                        'name' => $item['name'],
                        'slug' => $item['slug'],
                        'parent_id' => $permissionModel->id
                    ];

                    if(isset($item['url'])){
                        $args['url'] = $item['url'];
                    }

                    $dopPermissionModel->fill($args);
                    $dopPermissionModel->save();
                    $role->permissions()->attach($dopPermissionModel->id);


                    if(isset($item['children'])) {
                        foreach ($item['children'] as $val) {
                            $lastPermission = new AdminPermission();

                            $lastPermission->fill([
                                'name' => $val['name'],
                                'url' => $val['url'],
                                'slug' => $val['slug'],
                                'parent_id' => $dopPermissionModel->id
                            ]);
                            $lastPermission->save();
                            $role->permissions()->attach($lastPermission->id);
                        }
                    }
                }
            }
        }

    }
}

