<?php

namespace Customers\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string gateway_name
 * @property integer gateway_transaction_id
 * @property string type
 * @property string status
 * @property integer amount
 * @property string currency
 * @property false|string data
 * @property integer order_id
 * @property integer customer_id
 * @property mixed created_at
 * @property mixed action
 * @mixin Eloquent
 */

class CustomerPayment extends Model
{
    //
}
