<?php

namespace Core\Settings\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Shop\Catalog\Models\Relations\HasManySyncable;
use Customers\Models\Customer;
use Shop\Reviews\Models\ProductsReview;

/**
 * Class Product
 * @property mixed categories
 * @property mixed group
 * @property mixed id
 * @property mixed brand_id
 * @property mixed category_id
 * @property mixed images
 * @package Shop\Catalog\Models
 * @mixin \Eloquent
 */

class Slider extends Model
{

	use Translatable;

	protected $table = 'sliders';

	public $searchable = ['title', 'desc',];

	public $translatedAttributes = ['title', 'desc',
		'name', 'button_name','image','link','name'];

	public $translationModel = SliderTranslation::class;

	protected $fillable = [
		'post_type', 'active', 'category_id', 'page_id', 'link'
	];



}

