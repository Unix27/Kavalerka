<?php


namespace Shop\Catalog\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class AttributesValuesResource extends JsonResource
{
	public function toArray($request)
	{

		return [
			'id' => $this->id,
			'value' => $this->value,
			'attribute_id' => $this->attribute_id,
			'attribute' => $this->attribute,
			'product_id' => $this->product_id,
			'slug'=>$this->id,
			'title' => $this->title,
			'color' => $this->color,
		];
	}
}
