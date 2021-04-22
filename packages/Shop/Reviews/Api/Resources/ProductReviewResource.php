<?php


namespace Shop\Reviews\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			"id"            => $this->id,
			'parent_id'     => $this->parent_id,
			'rating'        => $this->rating,
			'name'          => $this->name,
			'email'         => $this->email,
			'comment'       => $this->comment,
			'customer_id'   => $this->customer_id,
			'is_verified'   => $this->is_verified,
			'product_id'    => $this->product_id,
			'category_id'   => $this->category_id,
			'answer'        => $this->answer->comment ?? '',
		];
	}
}
