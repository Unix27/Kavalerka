<?php

namespace Customers\Models;

use Admin\Models\AdminRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Shop\Orders\Models\Order;

/**
 * Class Customer
 * @property mixed first_name
 * @property mixed last_name
 * @property mixed|string password
 * @property mixed username
 * @property mixed email
 * @property CustomerWallet wallet
 * @package Customers\Models
 * @mixin \Eloquent
 */
class PhoneNumber extends Authenticatable
{

    protected $fillable = ['customer_id', 'phone'];

}
