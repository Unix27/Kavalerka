<?php

namespace Shop\Promotions\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionsCategoryTranslations extends Model
{
	protected $table = 'shop_promotions_category_translations';

	protected $fillable = ['title', 'heading', 'meta_title', 'meta_description', 'meta_keywords', 'category_id', 'locale'];
}
