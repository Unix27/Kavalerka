<?php

namespace Shop\Catalog\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeTranslation extends Model
{
    protected $table = 'shop_attribute_translations';

    protected $fillable = ['title', 'description'];
}
