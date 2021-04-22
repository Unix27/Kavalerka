<?php

namespace Shop\Promocodes\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;


class PromocodesBrand extends Model{

	protected $table = 'shop_promocodes_brands';

	protected $fillable = ['promocode_id', 'brand_id',];

}
