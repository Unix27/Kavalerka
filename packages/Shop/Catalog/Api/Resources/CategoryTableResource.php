<?php


namespace Shop\Catalog\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTableResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'sort' => $this->sort,
            'status_id' => $this->status->name,
            'active' => $this->status->id == 2?0:1,
            'image' => $this->image,
						'main_category_id' => $this->main_category_id,
						'show_on_front' => $this->show_on_front,
            'created_at' => $this->created_at->toDatetimeString(),
            'parent_id' => $this->parent_id,
            'category' => $this->parent ? $this->parent->title : null
        ];
    }
}
