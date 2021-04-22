<?php


namespace Shop\Catalog\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'product_id' => $this->product_id,
            'group_id'   => $this->group_id,
            'quantity'   => $this->quantity,
            'is_percent' => (boolean)$this->is_percent,
            'price'      => $this->price,
            'date_start' => $this->date_start,
            'date_end'   => $this->date_end,
						'type'       => $this->type,
            'group'      => $this->group??[],
            'operation'  => '1'
        ];
    }
}
