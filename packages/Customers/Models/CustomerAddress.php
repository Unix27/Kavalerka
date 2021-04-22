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
class CustomerAddress extends Model
{
	public $table = 'customer_addresses';
  	protected $fillable = ['country','address1','state','city', 'street', 'build', 'apartment', 'nova_poshta', 'ukr_poshta', 'justin', 'postcode','default','billing','customer_id'];

  	public $timestamps = false;
}
