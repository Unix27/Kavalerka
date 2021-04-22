<?php

namespace Shop\Orders\Database\Seeds;

use Blog\Models\BlogPost;
use Blog\Models\BlogPostTranslation;
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
use Admin\helpers\Helper;
class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $deliveries = ['Самовывоз','Курьер','Новая почта','Just In'];
        foreach($deliveries as $delivery) {
            OrderDelivery::create(['name' => $delivery]);
        }
        $statuses = ['Новый','Отменен','Отклонен','В обработке','Заблокирован','Возвращен','Ошибка','В процессе оплаты','Завершен','Доставлен'];

        foreach($statuses as $status){
            Status::create(['name'=>$status, 'slug' =>  Helper::slugify($status)]);
        }

        $paymentMethods = ['Оплата наличными','Оплата картой'];
        foreach($paymentMethods as $method) {
            OrderPaymentMethods::create(['name' => $method]);
        }

        $paymentStatus = ['Оплачен','Не оплачен', 'Деньги возвращены'];
        foreach($paymentStatus as $status) {
            OrderPaymentMethods::create(['name' => $status]);
        }

        $customers = Customer::all();

        for($i = 0; $i < 3; $i++) {

            $customer = $customers[rand(0, count($customers->toArray()) - 1)];

            $order = new Order();

            $order->customer_id = $customer->id;
            $order->customer_first_name = $customer->first_name;
            $order->customer_last_name = $customer->last_name;
            $order->customer_email = $customer->email;

            $order->status_id = null;
            $order->total_price = mt_rand(0, 3000);

            $order->save();
        }
    }
}
