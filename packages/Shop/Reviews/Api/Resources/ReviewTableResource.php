<?php


namespace Shop\Reviews\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ReviewTableResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			"id"            => $this->id,
			'rating'        => $this->rating,
			'name'          => $this->name,
			'email'         => $this->email,
			'customer_id'   => $this->customer_id,
			'show_on_front' => $this->show_on_front,
			'is_verified'   => $this->is_verified,
			'created_at'    => $this->created_at->toDatetimeString(),
			'updated_at'    => $this->updated_at->toDatetimeString(),
		];
	}
}
