<?php


namespace Pages\Api\Resources;


use Admin\Services\Datatable;
use Admin\Services\DatatableProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
	public function toArray($request)
	{

		$dt = new Datatable();

		return [
			'test'=>$this->all(),
			'id' => $this->id,
			'title' => $this->title,
			'content' => $this->content,
			'slug' => $this->slug,
			'meta_title' => $this->meta_title,
			'meta_keywords' => $this->meta_keywords,
			'meta_description' => $this->meta_description,
			'slider' => $dt->get($this->slider())
		];
	}
}
