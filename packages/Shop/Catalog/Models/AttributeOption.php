<?php

namespace Shop\Catalog\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed attribute_id
 */
class AttributeOption extends Model
{
    use Translatable;

    protected $table = 'shop_attribute_options';

    public $translatedAttributes = ['title'];

    public $translationModel = AttributeOptionTranslation::class;
}
