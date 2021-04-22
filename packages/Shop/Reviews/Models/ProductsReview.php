<?php

namespace Shop\Reviews\Models;

use Illuminate\Database\Eloquent\Model;
use Shop\Catalog\Models\Product;

class ProductsReview extends Model
{
	protected $table = 'shop_products_reviews';
	protected $fillable = ['parent_id', 'rating', 'name', 'email', 'comment', 'customer_id', 'product_id', 'category_id', 'is_verified'];

	public function product(){
		return $this->belongsTo(Product::class, 'product_id');
	}

	public function answer(){
		return $this->hasOne(ProductsReview::class, 'parent_id', 'id');
	}

	public function parent(){
		return $this->hasOne(ProductsReview::class, 'id', 'parent_id');
	}
}
