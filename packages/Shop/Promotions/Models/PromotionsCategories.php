<?php

namespace Shop\Promotions\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;


class PromotionsCategories extends Model{

	protected $table = 'shop_promotions_categories';

	protected $fillable = ['promotion_id', 'category_id',];

}
