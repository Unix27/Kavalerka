<?php

namespace Shop\Promocodes\Models;

use Customers\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Carbon\CarbonInterface;
use Shop\Catalog\Models\Brand;
use Shop\Catalog\Models\Category;
use Shop\Catalog\Models\Product;

/**
 * Class Attribute
 * @property mixed id
 * @package Shop\Promocodes\Models
 * @mixin \Eloquent
 */

class Promocode extends Model
{
	protected $table = 'shop_promocodes';

	protected $fillable = ['active', 'type', 'date_start', 'date_end','promocode', 'discount', 'is_percent', 'quantity', 'min_price'];

	public function promocodeProducts(){

		return $this->belongsToMany(Product::class, 'shop_promocodes_products');
	}

	public function promocodeCategories(){

		return $this->belongsToMany(Category::class, 'shop_promocodes_categories');
	}

	public function promocodeBrands(){
		return $this->belongsToMany(Brand::class, 'shop_promocodes_brands');
	}

}
