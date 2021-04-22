<?php

namespace Shop\Promotions\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionTranslations extends Model
{
	protected $table = 'shop_promotion_translations';

	protected $fillable = ['title', 'description'];
}
