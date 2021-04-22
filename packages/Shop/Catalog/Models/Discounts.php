<?php

namespace Shop\Catalog\Models;

use Astrotomic\Translatable\Translatable;
use Customers\Models\CustomerGroup;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @package Shop\Catalog\Models
 * @mixin \Eloquent
 */

class Discounts extends Model
{
    protected $table = 'shop_discounts';

    protected $fillable = ['product_id', 'group_id', 'quantity', 'is_percent', 'type', 'price', 'date_start', 'date_end'];

    public function group()
    {
        return $this->belongsTo(CustomerGroup::class);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
