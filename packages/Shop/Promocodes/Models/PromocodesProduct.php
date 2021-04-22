<?php

namespace Shop\Promocodes\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;


class PromocodesProduct extends Model{

	protected $table = 'shop_promocodes_products';

	protected $fillable = ['promocode_id', 'product_id',];

}
