<?php

namespace Shop\Catalog\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValueTranslation extends Model
{
    protected $table = 'shop_attribute_values_translations';

    protected $fillable = ['title'];
}
