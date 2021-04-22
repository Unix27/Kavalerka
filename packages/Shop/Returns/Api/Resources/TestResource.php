<?php


namespace Shop\Returns\Api\Resources;


use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
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

        return [
            "id" => $this->id,

            'customer_id' => $this->customer_id,

            'customer_email' => $this->customer_email,
            'customer_first_name' => $this->customer_first_name,
            'customer_last_name' => $this->customer_last_name,
            'name' => $this->customer_last_name .' '. $this->customer_first_name,
            'status' => $this->status,
            'total_price' => $this->total_price,

            'shipping_method' => $this->shipping_method,
            'shipping_country' => $this->shipping_country,
            'shipping_region' => $this->shipping_region,
            'shipping_city' => $this->shipping_city,
            'shipping_postcode' => $this->shipping_postcode,
            'shipping_address' => $this->shipping_address,

            'coupon_code' => $this->coupon_code,

            'currency_code' => $this->currency_code,
            'payment_method' => $this->payment_method,

            'items' => $items,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
