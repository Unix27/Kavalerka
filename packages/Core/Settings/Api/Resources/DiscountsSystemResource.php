<?php

namespace Core\Settings\Api\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountsSystemResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'id' => $this->id,
			'active' => $this->active,
			'percent' => $this->percent,
			'total' => $this->total,
		];
	}
}
