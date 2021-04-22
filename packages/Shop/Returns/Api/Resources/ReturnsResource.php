<?php


namespace Shop\Returns\Api\Resources;


use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReturnsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            'order' => $this->order()->with('items','payment_method','customer','delivery')->first(),
            'order_id' => $this->order_id,
            'user' => $this->order->customer,
            'product' => $this->product()->with('categories')->first(),
            'status' => $this->status,
            'reason' => $this->reason,
            'product_id' => $this->product_id,
            'reason_id' => $this->reason_id,
            'status_id' => $this->status_id,
            'customer_email' => $this->customer_email,
            'customer_first_name' => $this->customer_first_name,
            'customer_last_name' => $this->customer_last_name,
            'customer_phone' => $this->customer_phone,
            'customer_notes' => $this->customer_notes,
            'quantity' => $this->quantity,
            'variation_id' => $this->variation_id,
            'variation' => $this->variation,
            'packet' => $this->packet,

        ];
    }
}
