<?php

namespace Customers\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerGroup
 * @package Customers\Models
 * @mixin \Eloquent
 */

class CustomerGroup extends Model
{
    protected $fillable = ['name', 'active'];

    public $searchable = ['name'];
}
