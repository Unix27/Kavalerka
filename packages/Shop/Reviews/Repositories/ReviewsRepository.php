<?php


namespace Shop\Reviews\Repositories;

use Shop\Reviews\Models\ShopReview;

class ReviewsRepository
{
	protected $locale;

	public function __construct()
	{
		$this->locale = request()->input('locale') ?? app()->getLocale();
	}

	public function create(array $attributes){
		$review = ShopReview::create($attributes);
		$review->save();

		return $review;
	}

	public function update(ShopReview $review, array $attributes){
		$review->fill($attributes);

		if(isset($attributes['answer']) && $attributes['answer']){
			if(isset($review->answer)){
				$answer = $review->answer;
				$answer->comment = $attributes['answer'];
			} else {
				$answer = ShopReview::create([
					'name' => 'admin',
					'comment' => $attributes['answer'],
					'parent_id' => $review->id,
					]);
			}
			$answer->save();

		}

		$review->save();

		return $review;
	}
}
