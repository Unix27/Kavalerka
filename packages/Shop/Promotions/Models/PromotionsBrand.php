<?php

namespace Shop\Promotions\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;


class PromotionsBrand extends Model{

	protected $table = 'shop_promotions_brands';

	protected $fillable = ['promotion_id', 'brand_id',];

}
