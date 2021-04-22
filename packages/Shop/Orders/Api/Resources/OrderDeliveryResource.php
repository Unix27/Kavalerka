<?php


namespace Shop\Orders\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class OrderDeliveryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            'price' => $this->price
        ];
    }
}
