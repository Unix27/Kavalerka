<?php

namespace Core\Settings\Database\Seeds;

use Blog\Models\BlogPost;
use Blog\Models\BlogPostTranslation;
use Core\Settings\Models\Currency;
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

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = Currency::create(
            [
                'name' => 'Гривна',
                'code' => 'UAH',
                'left_symbol' => '',
                'right_symbol' => '₴',
                'number_symbol_comma' => '2',
                'value' => '1',
                'active' => 1,
                'default' => 1
            ]
        );
    }
}
