<?php


namespace Shop\Promotions\Repositories;

use Shop\Catalog\Models\Discounts;
use Shop\Catalog\Models\Product;
use Shop\Promotions\Models\Promotion as Model;

class PromotionRepositories
{
	protected $locale;

	public function __construct()
	{
		$this->locale = request()->input('locale') ?? app()->getLocale();
	}

	public function create(array $attributes)
	{
		$promotion = new Model();
		$promotion->fill($attributes);

		if($attributes['type'] == true){
			$promotion->type = 'retail';
		} else {
			$promotion->type = 'opt';
		}

		$promotion->save();

		$promotion->translateOrNew(app()->getLocale())->fill($attributes);

		if(isset($attributes['products'])){
			$promotion->promotionProducts()->sync($attributes['products']);

			$products = Product::whereIn('id', $attributes['products'])->get();

			foreach($products as $product){
				$discount = $product->discounts()->first();
				if(isset($discount)){
					$discount = $product->discounts()->first();
				}else{
					$discount = new Discounts();
				}
//				$discount->group_id = $model->id;
				$discount->price      = $attributes['discount'];
				$discount->date_start = $attributes['date_start'];
				$discount->date_end   = $attributes['date_end'];
				$discount->is_percent = $attributes['is_percent'];
				$discount->product_id = $product->id;

				$discount->save();
			}
		}
		if(isset($attributes['brands'])){
			$promotion->promotionBrands()->sync($attributes['brands']);
		}
		if(isset($attributes['categories'])){
			$promotion->promotionCategories()->sync($attributes['categories']);
		}

		$promotion->save();

		return $promotion;
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
			$model->promotionProducts()->sync($attributes['products']);
			$products = Product::whereIn('id', $attributes['products'])->get();

			foreach($products as $product){
				$discount = $product->discounts()->first();
				if(isset($discount)){
					$discount = $product->discounts()->first();
				}else{
					$discount = new Discounts();
				}
//				$discount->group_id = $model->id;
				$discount->price = $attributes['discount'];
				$discount->date_start = $attributes['date_start'];
				$discount->date_end = $attributes['date_end'];
				$discount->is_percent = $attributes['is_percent'];
				$discount->product_id = $product->id;

				$discount->save();
			}
		}

		if(isset($attributes['brands'])){
			$model->promotionBrands()->sync($attributes['brands']);
		}
		if(isset($attributes['categories'])){
			$model->promotionCategories()->sync($attributes['categories']);
		}

		$model->save();

		return $model;
	}
}
