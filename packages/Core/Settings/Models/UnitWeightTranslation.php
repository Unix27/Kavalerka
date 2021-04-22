<?php

namespace Core\Settings\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AttributeGroup
 * @package Shop\Catalog\Models
 * @mixin \Eloquent
 */

class UnitWeightTranslation extends Model
{
    protected $table = 'shop_unit_weights_translations';

    protected $fillable = ['title','unit'];


}
