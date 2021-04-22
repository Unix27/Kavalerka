<?php

namespace Admin\Api\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminPermissionsResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'label' => $this->name,
            'slug' => $this->slug,
            'children' => $this->children()->get(),
        ];
    }
}
