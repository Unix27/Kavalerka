<?php

namespace Shop\Orders\Observers;

use Customers\Models\Customer;
use Shop\Orders\Models\Order;
use Shop\Orders\Models\OrderHistory;


class OrderObserver
{
    /**
     * Handle the customer "created" event.
     *
     * @param  \App\Customer  $order
     * @return void
     */
    public function created(Order $order)
    {
        OrderHistory::create([
            'order_id' => $order->id,
            'user_id' => $order->customer_id,
            'text' => 'Cделал заказ',
        ]);
    }

    /**
     * Handle the customer "updated" event.
     *
     * @param  \App\Customer  $order
     * @return void
     */
    public function updated(Order $order)
    {
        $fields = [
            'customer_id' => 'пользователя на ',
            'group_id' => 'группу на ',
            'status_id' => 'статус на ',
            'shipping_country' => ' страну доставки на ',
            'shipping_region' => 'область доставки на ',
            'shipping_city' => 'город доставки на ',
            'shipping_postcode' => '',
            'shipping_address' => 'адрес доставки на ',
            'coupon_code' => ' купон',
            'currency_code' => ' код валюты',
            'payment_method' => 'метод оплаты',
            'admin_notes' => 'комментарий пользователя на ',
            'customer_notes' => 'комментарий администратора на ',
        ];

        $text = '';

        foreach($order->getDirty() as $key => $val){
            if(isset($fields[$key])){
                switch ($key){
                    case 'customer_id':
                        $field = $order->customer->first_name;
                        $text .=  $fields[$key].$field." \n";
                    break;

                    default:
                        $field = $val;
                        $text .=  $fields[$key].$field." \n";
                    break;

                }
            }
        }

//        foreach($order as $key => $val) {
//            $field = '';
//
//
//            if ($order->isDirty($key)) {
//                OrderHistory::create([
//                    'order_id' => $order->id,
//                    'user_id' => $order->customer_id,
//                    'text' => 'popalo',
//                ]);
//
//                // email has changed
//
////                switch ($key){
////                    case 'customer_id':
////                        $field = $order->customer->first_name;
////                        $text .=  $fields[$key].$field." \n";
////                    break;
////
////                    default:
////                        $field = $val;
////                        $text .=  $fields[$key].$field." \n";
////                    break;
////
////                }
//            }
//        }


//        if ($order->isDirty('customer_id')) {
//            // email has changed
//
//            $field = $order->customer->first_name;
//            $text .=  $fields['customer_id'].$field." \n";
//
//        }

        if($text){
            OrderHistory::create([
                'order_id' => $order->id,
                'user_id' => $order->customer_id,
                'text' => 'изменил '.$text,
            ]);
        }


    }





    /**
     * Handle the customer "deleted" event.
     *
     * @param  \App\Customer  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the customer "restored" event.
     *
     * @param  \App\Customer  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the customer "force deleted" event.
     *
     * @param  \App\Customer  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }


    public function change($model){

    }



}
