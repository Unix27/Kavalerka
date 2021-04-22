<?php

namespace Customers\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed|string address1
 * @property mixed customer_id
 * @property mixed|string country
 * @property mixed|string state
 * @property mixed|string city
 * @property mixed|string postcode
 */
class CustomerDeliveries extends Model
{
	public $table = 'customer_deliveries';
  	protected $fillable = ['country','address','state','city','postcode','default','billing','payment_id'];

  	public $timestamps = false;
}
