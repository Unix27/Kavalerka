<?php

namespace Shop\Promotions\Models;

use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;


class PromotionsCategory extends Model{

	use Translatable;

	protected $table = 'shop_promotions_category';

	public $searchable = ['title', 'slug'];

	public $translatedAttributes = ['title', 'heading', 'meta_title', 'meta_description', 'meta_keywords'];

	public $translationForeignKey = 'category_id';

	public $translationModel = PromotionsCategoryTranslations::class;

	protected $fillable = [ 'slug', 'active' ];

	public function promotions()
	{
		return $this->hasMany(Promotion::class, 'category_id');
	}

}
