<?php

namespace Shop\Catalog\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bool|mixed url
 * @property mixed product_id
 * @mixin \Eloquent
 */
class Status extends Model
{
    protected $table = 'statuses';
    public $fillable = ['name'];

    public $timestamps = false;

}
