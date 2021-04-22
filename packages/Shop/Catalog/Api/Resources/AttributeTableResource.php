<?php


namespace Shop\Catalog\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class AttributeTableResource extends JsonResource
{
    public function toArray($request)
    {

			return [
				'id' => $this->id,
				'title' => $this->title??'',
				'attribute_group_id' => $this->attribute_group_id,
				'group_text' => $this->group->title??'',
				'active' => $this->active,
				'use_color' => $this->use_color,
				'image' => $this->image
			];
    }
}
