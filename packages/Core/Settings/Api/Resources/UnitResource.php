<?php

namespace Core\Settings\Api\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'value' => $this->value,
            'unit' => $this->unit,
            'created_at' => $this->created_at,
            'default' => $this->default,
        ];
    }
}
