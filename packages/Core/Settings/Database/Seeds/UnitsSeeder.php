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

class UnitsSeeder extends Seeder
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
              'title' => 'Centimeter',
              'unit' => 'cm'
          ]
        ];

        $model = Unit::create(['value' => '1.00000000','default' => 1]);
        foreach ($options as $locale => $translation) {
            $model->translateOrNew($locale)->fill($translation);
        }
        $model->save();

    }
}
