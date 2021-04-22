<?php


namespace Customers\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class CustomerGroupTableResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            "id" => $this->id,
            "name" => $this->name,
            "active" => $this->active
        ];
    }
}
