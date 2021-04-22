<?php

namespace Shop\Promotions\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;


class PromotionsProduct extends Model{

	protected $table = 'shop_promotions_products';

	protected $fillable = ['promotion_id', 'product_id',];

}
