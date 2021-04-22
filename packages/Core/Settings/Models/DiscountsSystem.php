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

class DiscountsSystem extends Model
{
	protected $table = 'discounts_system';

	protected $fillable = [
		'percent', 'active', 'total'
	];



}

