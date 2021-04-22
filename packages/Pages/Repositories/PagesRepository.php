<?php


namespace Pages\Repositories;


use Blog\Models\BlogCategory;
use Blog\Models\BlogPost;
use Blog\Models\BlogPostTranslation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Localization;
use Pages\Models\Page as Model;
use Pages\Models\PageTranslation;
use Storage;
use Str;

class PagesRepository
{

	public function create($attributes)
	{
		if(empty($attributes['title']))
			$attributes['title'] = 'Без имени';

		if(empty($attributes['slug']))
			$attributes['slug'] = \Str::slug($attributes['title']);

		$model = Model::create($attributes);

		$model->translateOrNew(app()->getLocale())->fill($attributes);

		$model->save();

		return $model;
	}

	public function update(Model $model, $attributes)
	{
		if(empty($attributes['slug']))
			$attributes['slug'] = \Str::slug($attributes['title']);

		$model->fill($attributes);

		$model->translateOrNew(app()->getLocale())->fill($attributes);

		$model->save();


		return $model;
	}

	protected function prepareAttributes($attributes)
	{
		if (empty($attributes['slug']))
			$attributes['slug'] = Str::slug($attributes['name']);


		return $attributes;
	}
}
