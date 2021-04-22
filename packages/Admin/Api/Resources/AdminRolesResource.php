<?php

namespace Admin\Api\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminRolesResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'permissions' => $this->permissions->pluck('id')
        ];
    }
}
