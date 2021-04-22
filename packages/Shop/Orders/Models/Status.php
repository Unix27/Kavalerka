<?php

namespace Shop\Orders\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

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
class Status extends Model
{

    protected $table = 'shop_order_statuses';

    protected $fillable = ['name','color','slug', 'locale'];

    public $timestamps = false;

    public function payment_statuses(){
        return $this->belongsToMany(OrderPaymentStatus::class, 'shop_order_statuses_payment_statuses', 'payment_status_id', 'order_status_id')->withPivot('order_id');;
    }

}
