<?php


namespace Shop\Catalog\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class AttributeGroupTableResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'code' => $this->code,
            'sort' => $this->sort,
            'active' => $this->active
        ];
    }
}
