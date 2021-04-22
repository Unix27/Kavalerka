<?php


namespace Core\Settings\Repositories;
use Core\Settings\Models\DiscountsSystem as Model;

class DiscountsSystemRepository
{
	protected $locale;

	public function __construct()
	{
		$this->locale = request()->input('locale') ?? app()->getLocale();
	}

	public function create(array $attributes)
	{
		$model = Model::create([]);
		$model->save();

		$model->fill($attributes);
		$model->save();

		return $model;
	}

	public function update(Model $model, array $attributes)
	{
		$model->fill([]);
		$model->save();

		$model->fill($attributes);
		$model->save();

		return $model;
	}


}
