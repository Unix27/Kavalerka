<?php

namespace Shop\Reviews\Models;

use Illuminate\Database\Eloquent\Model;

class ShopReview extends Model
{
	protected $table = 'shop_reviews';
	protected $fillable = ['parent_id', 'rating', 'name', 'email', 'comment', 'customer_id', 'show_on_front', 'is_verified'];

	public function answer(){

		return $this->hasOne(ShopReview::class, 'parent_id', 'id');
	}
}
