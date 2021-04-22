<?php

namespace Shop\Promocodes\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;


class PromocodesCategories extends Model{

	protected $table = 'shop_promocodes_categories';

	protected $fillable = ['promocode_id', 'category_id',];

}
