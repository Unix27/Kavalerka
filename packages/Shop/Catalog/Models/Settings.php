<?php

namespace Shop\Catalog\Models;

use Astrotomic\Translatable\Translatable;
use Customers\Models\CustomerGroup;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @package Shop\Catalog\Models
 * @mixin \Eloquent
 */

class Settings extends Model
{
	protected $table = 'settings';

	protected $fillable = [ 'name', 'value', 'group', 'locale' ];


}
