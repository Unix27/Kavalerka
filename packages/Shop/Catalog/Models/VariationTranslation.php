<?php

namespace Shop\Catalog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
/**
 * @property bool|mixed url
 * @property mixed product_id
 * @mixin \Eloquent
 */
class VariationTranslation extends Model
{
	protected $table = 'shop_variation_translations';

	public $fillable = ['locale', 'title', 'description', 'variation_id'];

}
