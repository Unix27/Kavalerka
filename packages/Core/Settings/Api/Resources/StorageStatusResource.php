<?php

namespace Core\Settings\Api\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StorageStatusResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
        ];
    }
}
