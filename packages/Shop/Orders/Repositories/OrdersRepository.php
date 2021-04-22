<?php


namespace Shop\Orders\Repositories;

use Shop\Orders\Models\Order;
use Shop\Orders\Models\OrderItem;
use Customers\Repositories\CustomersRepository;
use Shop\Orders\Models\Status;
use Shop\Returns\Models\Returns;

class OrdersRepository
{
    protected $locale;

    public function __construct()
    {
        $this->locale = request()->input('locale') ?? app()->getLocale();
    }

    public function create(array $attributes){
//			if(!$attributes['customer_id']){
//					$customer = new CustomersRepository();
//
//					$attributes['first_name'] = $attributes['customer_first_name'];
//					$attributes['last_name'] = $attributes['customer_last_name'];
//					$attributes['phone'] = $attributes['customer_phone'];
//					$attributes['middle_name'] = $attributes['customer_middle_name'];
//
//					$attributes['email'] = $attributes['customer_email'];
//					$attributes['customer_id'] = $customer->create($attributes)->id;
//			}

//			if($attributes['customer_id'] == -1){
//					$attributes['customer_id'] = null;
//			}

			$attributes['status_id'] = $attributes['status'];

			$order = Order::create($attributes);
			$order->save();

			$order->status_id = $attributes['status'];

			$order->shipping_method   = $attributes['method_delivery'];
			$order->shipping_city     = $attributes['your_city'];
			$order->shipping_address  = $attributes['your_warehouse'];
			$order->customer_notes    = $attributes['message'];
			$order->customer_phone    = $attributes['phone'];
			$order->shipping_price    = $attributes['shipping_price'];
			$order->payment_method_id = $attributes['payment_method'];
			$order->delivery_id       = $attributes['method_delivery_id'];

			$order->total_price = $this->saveOrderItems($attributes,$order);
			if(isset($attributes['group']) && $attributes['group']){
					$order->group_id = $attributes['group']['id'];
			}

			$order->save();

			return $order;
    }

    public function update(Order $order, array $attributes)
    {

//        if(!$attributes['customer_id']){
//            $customer = new CustomersRepository();
//
//            $attributes['first_name'] = $attributes['customer_first_name'];
//            $attributes['last_name'] = $attributes['customer_last_name'];
//            $attributes['phone'] = $attributes['customer_phone'];
//            $attributes['middle_name'] = $attributes['customer_middle_name'];
//
//
//            $attributes['email'] = $attributes['customer_email'];
//            $attributes['customer_id'] = $customer->create($attributes)->id;
//        }

        $order->status_id = $attributes['status'];

//        if($attributes['customer_id'] == -1){
//            $attributes['customer_id'] = null;
//        }

        $order->fill($attributes);

//				$order->shipping_method  = $attributes['method_delivery'];
//				$order->shipping_city    = $attributes['your_city'];
//				$order->shipping_address = $attributes['your_warehouse'];
//				$order->customer_notes   = $attributes['message'];
//				$order->customer_phone   = $attributes['phone'];

        $order->save();

        foreach ($order->items as $item) {
            $item->delete();
        }

        $status = Status::where('slug','vozvrashhen')->first();

        if($status->id == $attributes['status']){
            $this->returnStatus($attributes['items']);
        }

        $order->status_id = $attributes['status'];
        $order->total_price = $this->saveOrderItems($attributes,$order);

        if(isset($attributes['group']) && $attributes['group']){
            $order->group_id = $attributes['group']['id'];
        }else{
            $order->group_id = null;
        }

        $order->save();

        return $order;
    }

    public function saveOrderItems($attributes,$order){
        $itemsPrice = 0;

        foreach ($attributes['items'] as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->title = $item['title'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->price = $item['price'];
            $orderItem->product_id = $item['product_id'];

            if(isset($item['product']['product_id'])){
                $orderItem->variation_id = $item['product_id'];
                $orderItem->product_id = $item['product']['product_id'];

            }


            $orderItem->save();

            $itemsPrice += $orderItem->quantity * $orderItem->price;
        }

        return $itemsPrice;
    }


    public function returnStatus($items){
        $return = new Returns();
        foreach($items as $item){
            $return->fill($item);
        }
        $return->save();
    }

}
