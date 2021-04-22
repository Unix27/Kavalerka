<?php


namespace Blog\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request)
    {

           return [
               'id' => $this->id,
               'title' => $this->title,
               'content' => $this->content,
               'image' => $this->image,
               'category_id' => $this->category_id,
               'slug' => $this->slug,
						   'excerpt' => $this->excerpt,
               'meta_title' => $this->meta_title,
               'meta_keywords' => $this->meta_keywords,
               'meta_description' => $this->meta_description,
//               'related' => $this->related->pluck('id'),
//               'tags' => $this->tags
           ];
    }
}
