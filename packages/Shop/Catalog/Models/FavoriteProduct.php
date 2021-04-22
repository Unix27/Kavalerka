<?php

namespace Shop\Catalog\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;


class FavoriteProduct extends Model{

	protected $fillable = ['product_id', 'customer_id',];

}
