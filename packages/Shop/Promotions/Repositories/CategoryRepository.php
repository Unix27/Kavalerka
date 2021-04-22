<?php


namespace Shop\Promotions\Repositories;

use Shop\Promotions\Models\PromotionsCategory as Model;
use Storage;

class CategoryRepository
{
	protected $locale;
	protected $imagesPath;

	public function __construct()
	{
		$this->locale = app()->getLocale();
		$this->imagesPath = 'shop/images';
	}

	public function create(array $attributes)
	{
		if(empty($attributes['slug']))
			$attributes['slug'] = \Str::slug($attributes['title']);

		if(isset($attributes['active']) && $attributes['active'])
			$attributes['status_id'] = 1;
		else
			$attributes['status_id'] = 2;

		$model = Model::create($attributes);

		$model->translateOrNew(app()->getLocale())->fill($attributes);

		// if(isset($attributes['image'])) {
		//     $image = Storage::put($this->imagesPath, $attributes['image']);
		//     $model->image = $image;
		// }

		$model->save();

		return $model;
	}

	public function update(Model $model, array $attributes)
	{
		if(empty($attributes['slug']))
			$attributes['slug'] = \Str::slug($attributes['title']);


		if(isset($attributes['active']) && $attributes['active'])
			$attributes['status_id'] = 1;
		else
			$attributes['status_id'] = 2;

		$model->fill($attributes);

		$model->save();

		$model->translateOrNew(app()->getLocale())->fill($attributes);

		// if(isset($attributes['image'])) {
		//     $image = Storage::put($this->imagesPath, $attributes['image']);
		//     $model->image = $image;
		// }

		$model->save();

		return $model;
	}
}
