<?php


namespace Shop\Catalog\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class BrandTableResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
						'description' => $this->description,
            'sort' => $this->sort,
            'active' => $this->active,
            'image' => $this->image
        ];
    }
}
