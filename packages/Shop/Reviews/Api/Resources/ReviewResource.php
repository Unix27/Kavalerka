<?php


namespace Shop\Reviews\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
			'show_on_front' => $this->show_on_front,
			'is_verified'   => $this->is_verified,
			'answer'        => $this->answer->comment ?? '',
		];
	}
}
