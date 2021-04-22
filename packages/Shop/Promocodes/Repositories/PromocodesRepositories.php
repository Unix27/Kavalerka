<?php


namespace Shop\Promocodes\Repositories;

use Shop\Catalog\Models\Discounts;
use Shop\Catalog\Models\Product;
use Shop\Promocodes\Models\Promocode as Model;

class PromocodesRepositories
{
	protected $locale;

	public function __construct()
	{
		$this->locale = request()->input('locale') ?? app()->getLocale();
	}

	public function create(array $attributes)
	{
		$promocode = new Model();
		$promocode->fill($attributes);

		if($attributes['type'] == true){
			$promocode->type = 'retail';
		} else {
			$promocode->type = 'opt';
		}

		$promocode->save();

		if(isset($attributes['products'])){
			$promocode->promocodeProducts()->sync($attributes['products']);
		}
		if(isset($attributes['brands'])){
			$promocode->promocodeBrands()->sync($attributes['brands']);
		}
		if(isset($attributes['categories'])){
			$promocode->promocodeCategories()->sync($attributes['categories']);
		}

		$promocode->save();

		return $promocode;
	}

	public function update(Model $model, array $attributes)
	{
		$model->fill($attributes);

		if($attributes['type'] == true){
			$model->type = 'retail';
		} else {
			$model->type = 'opt';
		}

		if(isset($attributes['products'])){
			$model->promocodeProducts()->sync($attributes['products']);
		}
		if(isset($attributes['brands'])){
			$model->promocodeBrands()->sync($attributes['brands']);
		}
		if(isset($attributes['categories'])){
			$model->promocodeCategories()->sync($attributes['categories']);
		}

		$model->save();

		return $model;
	}
}
