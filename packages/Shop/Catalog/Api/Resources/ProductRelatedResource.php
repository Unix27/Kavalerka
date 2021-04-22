<?php


namespace Shop\Catalog\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ProductRelatedResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->product_id,
            'table_id' => $this->id,
            'title' => $this->product->title,
            'operation' => '1'
        ];
    }
}
