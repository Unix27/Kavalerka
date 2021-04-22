<?php


namespace Shop\Reviews\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use Shop\Catalog\Models\Product;

class ProductReviewTableResource extends JsonResource
{
	public function toArray($request)
	{
		$product = Product::find($this->product_id)->first();
		return [
			"id"            => $this->id,
			'rating'        => $this->rating,
			'name'          => $this->name,
			'email'         => $this->email,
			'customer_id'   => $this->customer_id,
			'product_id'    => $this->product_id,
			'is_verified'   => $this->is_verified,
			'created_at'    => $this->created_at->toDatetimeString(),
			'updated_at'    => $this->updated_at ? $this->updated_at->toDatetimeString() : $this->updated_at,

			'product_title' => $product->title,
		];
	}
}
