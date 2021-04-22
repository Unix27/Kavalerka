<?php

namespace Shop\Catalog\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AttributeGroup
 * @package Shop\Catalog\Models
 * @mixin \Eloquent
 */

class AttributeGroupTranslation extends Model
{
    protected $table = 'shop_attribute_group_translations';

    protected $fillable = ['title'];
}
