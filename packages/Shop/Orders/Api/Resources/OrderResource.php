<?php


namespace Shop\Orders\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use Shop\Orders\Models\OrderDelivery;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {

        $items = [];

        $total = 0;

        foreach ($this->items()->with('product','variation')->get() as $item) {

            $total += $item->quantity * $item->price;
            $res = $item;
            $res['product'] = $item->product;
            if($item->variation) {
                $res['variation'] = $item->variation;
                $res['attrVariation'] = $item->variation->getAttributeVariations();
            }
            $items[] = $res;
        }

        $shipping_show = $this->group ? false : true;


        return [
            "id" => $this->id,
            'delivery_id' => $this->delivery_id,
            'customer_id' => $this->customer_id,
            'group' => $this->group,
            'itemsTotal' => $total,
            'customer_email' => $this->customer_email,
            'customer_first_name' => $this->customer_first_name,
            'customer_last_name' => $this->customer_last_name,


            'status_name' => $this->status->name??'',
            'status' => $this->status_id,
            'total_price' => $this->total_price,

            'shipping_method' => $this->shipping_method,
            'shipping_country' => $this->shipping_country,
            'shipping_region' => $this->shipping_region,
            'shipping_city' => $this->shipping_city,
            'shipping_postcode' => $this->shipping_postcode,
            'shipping_address' => $this->shipping_address,
						'delivery_method' => OrderDelivery::find($this->delivery_id),

            'coupon_code' => $this->coupon_code,

            'currency_code' => $this->currency_code,
            'payment_method_id' => $this->payment_method_id,
            'payment_method' => $this->payment_method,
            'customer' => $this->customer,
            'items' => $items,
            'created_at' => $this->created_at,
            'admin_notes' => $this->admin_notes,
            'customer_notes' => $this->customer_notes,
            'shipping_show' => $shipping_show,
            'history' => $this->histories()->with('user','user.role')->get()
        ];
    }
}
