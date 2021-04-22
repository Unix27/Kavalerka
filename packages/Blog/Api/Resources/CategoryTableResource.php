<?php


namespace Blog\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTableResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'created_at' => $this->created_at->toDatetimeString(),
        ];
    }
}
