<?php

namespace Core\Settings\Database\Seeds;

use Blog\Models\BlogPost;
use Blog\Models\BlogPostTranslation;
use Core\Settings\Models\StorageStatus;
use Core\Settings\Models\Unit;
use Customers\Models\Customer;
use DB;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Shop\Catalog\Models\AttributeGroup;
use Shop\Catalog\Models\Category;
use Shop\Orders\Models\Order;
use Shop\Orders\Models\OrderDelivery;
use Shop\Orders\Models\OrderPaymentMethods;
use Shop\Orders\Models\Status;

class StorageStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = [
            'ru' => [
                'name' => '2-3 Days',
            ],
            'ru' => [
                'name' => 'In Stock',
            ],
            'ru' => [
                'name' => 'Out Of Stock',
            ],
        ];

        foreach ($options as $locale => $translation) {
            $model = StorageStatus::create([]);
            $model->translateOrNew($locale)->fill($translation);
            $model->save();
        }

    }
}
