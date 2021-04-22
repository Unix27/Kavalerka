<?php


namespace Shop\Promotions\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTableResource extends JsonResource
{
	public function toArray($request)
	{

		return [
			'id' => $this->id,
			'title' => $this->title,
//			'sort' => $this->sort,
			'slug' => $this->slug,
			'active' => $this->active,
			'image' => $this->image,
			'heading' => $this->heading,
			'meta_title' => $this->meta_title,
			'meta_description' => $this->meta_description,
			'meta_keywords' => $this->meta_keywords,
			'created_at' => $this->created_at->toDatetimeString(),
			'updated_at' => $this->updated_at,
		];
	}
}
