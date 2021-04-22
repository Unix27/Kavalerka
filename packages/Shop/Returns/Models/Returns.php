<?php

namespace Shop\Returns\Models;

use Astrotomic\Translatable\Translatable;
use Customers\Models\Customer;
use Customers\Models\CustomerGroup;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Shop\Catalog\Models\Product;
use Shop\Catalog\Models\Variations;
use Shop\Orders\Models\Order;
use Shop\Orders\Models\Status;

/**
 * Class Attribute
 * @mixin \Eloquent
 * @property mixed customer_id
 * @property mixed|string status
 * @property mixed customer_first_name
 * @property mixed customer_last_name
 * @property mixed customer_email
 * @property int|mixed total_price
 */
class Returns extends Model
{

    protected $table = 'shop_returns';

    protected $fillable = ['order_id','reason_id','status_id','customer_email','customer_first_name','customer_last_name',
        'customer_phone','customer_notes','quantity','product_id','variation_id','packet'];


    public function status()
    {
        return $this->belongsTo(ReturnStatuses::class);
    }

    public function reason()
    {
        return $this->belongsTo(ReturnReasons::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function variation()
    {
        return $this->belongsTo(Variations::class);
    }
}
