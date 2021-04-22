<?php


namespace Blog\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class PostTableResource extends JsonResource
{
    public function toArray($request)
    {

           return [
               'id' => $this->id,
               'title' => $this->title,
               'content' => $this->content,
               'image' => $this->image,
               'category_text' => @$this->category->title ?? 'Нет',
               'category_id' => $this->category_id,
               'active' => $this->active
           ];
    }
}
