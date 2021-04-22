<?php

namespace Shop\Orders\Models;

use Astrotomic\Translatable\Translatable;
use Customers\Models\Customer;
use Customers\Models\CustomerGroup;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OrderHistory extends Model
{

    protected $table = 'shop_orders_history';

    protected $fillable = ['order_id','text','user_id'];

//    public $timestamps = false;



    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d.m.Y H:i:s');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d.m.Y H:i:s');
    }

    public function user(){
        return $this->belongsTo(Customer::class);
    }


}
