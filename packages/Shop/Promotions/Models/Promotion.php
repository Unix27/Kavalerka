<?php

namespace Shop\Promotions\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Carbon\CarbonInterface;
use Shop\Catalog\Models\Brand;
use Shop\Catalog\Models\Category;
use Shop\Catalog\Models\Product;

/**
 * Class Attribute
 * @property mixed id
 * @package Shop\Promotions\Models
 * @mixin \Eloquent
 */

class Promotion extends Model
{
	use Translatable;

	protected $table = 'shop_promotions';

	public $searchable = ['title', 'description'];

	public $translatedAttributes = ['title', 'description'];

	public $translationModel = PromotionTranslations::class;

	protected $fillable = ['active', 'type', 'date_start', 'date_end','main_category', 'category_id', 'image', 'discount', 'is_percent', 'upc', 'ean', 'jan', 'isbn', 'mpn'];

	public function remainingDays() {
		$formated_date = Carbon::parse($this->date_end);
//		return $formated_date->diffInDays(Carbon::now());
		return $formated_date->diffForHumans(['syntax' => CarbonInterface::DIFF_ABSOLUTE, 'short' => false, 'parts' => 3,]);
//		return $formated_date->diffForHumans(Carbon::now(), CarbonInterface::DIFF_ABSOLUTE, false, 4);
	}

	public function promotionProducts(){

		return $this->belongsToMany(Product::class, 'shop_promotions_products');
	}

	public function promotionCategories(){

		return $this->belongsToMany(Category::class, 'shop_promotions_categories');
	}

	public function promotionBrands(){
		return $this->belongsToMany(Brand::class, 'shop_promotions_brands');
	}

}
