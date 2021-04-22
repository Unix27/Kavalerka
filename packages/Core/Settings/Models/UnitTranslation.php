<?php

namespace Core\Settings\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AttributeGroup
 * @package Shop\Catalog\Models
 * @mixin \Eloquent
 */

class UnitTranslation extends Model
{
    protected $table = 'shop_units_translations';

    protected $fillable = ['title','unit'];
}
