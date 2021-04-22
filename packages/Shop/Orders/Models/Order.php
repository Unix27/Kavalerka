<?php

namespace Shop\Orders\Models;

use Astrotomic\Translatable\Translatable;
use Customers\Models\Customer;
use Customers\Models\CustomerGroup;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
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
class Order extends Model
{

    protected $table = 'shop_orders';

    public $searchable = ['customer_email', 'customer_first_name',
        'customer_last_name'];

    protected $fillable = ['customer_id', 'customer_email', 'customer_first_name', 'customer_last_name',
        'status_id', 'price', 'total_item_count', 'total_qty_ordered',
        'shipping_method', 'shipping_country', 'shipping_address',
        'shipping_region', 'shipping_city', 'shipping_postcode',
        'admin_notes', 'customer_notes',
        'coupon_code', 'currency_code', 'payment_method_id','group_id','delivery_id'];


    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function delivery()
    {
        return $this->belongsTo(OrderDelivery::class);
    }

    public function group()
    {
        return $this->belongsTo(CustomerGroup::class);
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d.m.Y H:i:s');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d.m.Y H:i:s');
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function histories(){
        return $this->hasMany(OrderHistory::class,'order_id');
    }

    public function payment_method()
    {
        return $this->belongsTo(OrderPaymentMethods::class);
    }


}
