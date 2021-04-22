<?php

namespace Shop\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Shop\Catalog\Models\Product;
use Shop\Catalog\Models\Variations;

class OrderItem extends Model
{
    protected $table = 'shop_order_items';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variation()
    {
        return $this->belongsTo(Variations::class);
    }

}
