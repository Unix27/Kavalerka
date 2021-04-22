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
class OrderPaymentMethods extends Model
{

    protected $table = 'shop_order_payments_methods';

    protected $fillable = ['name'];

    public $timestamps = false;




}
