<?php


namespace Shop\Catalog\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ShopStatusesResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
