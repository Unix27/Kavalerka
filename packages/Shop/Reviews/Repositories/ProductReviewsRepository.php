<?php


namespace Shop\Reviews\Repositories;

use Shop\Reviews\Models\ProductsReview;

class ProductReviewsRepository
{
	protected $locale;

	public function __construct()
	{
		$this->locale = request()->input('locale') ?? app()->getLocale();
	}

	public function create(array $attributes){
		$review = ProductsReview::create($attributes);
		$review->save();

		return $review;
	}

	public function update(ProductsReview $review, array $attributes){
		$review->fill($attributes);

		if(isset($attributes['answer']) && $attributes['answer']){
			if(isset($review->answer)){
				$answer = $review->answer;
				$answer->comment = $attributes['answer'];
			} else {
				$answer = ProductsReview::create([
					'name' => 'admin',
					'comment' => $attributes['answer'],
					'parent_id' => $review->id,
					'product_id' => $review->product_id,
				]);
			}
			$answer->save();
		}

		$review->save();

		return $review;
	}
}
