<?php

namespace Core\Settings\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Shop\Catalog\Models\AttributeGroupTranslation;

class Unit extends Model
{
    use Translatable;

    public $table = 'shop_units';
    public $fillable = ['value','default'];
    public $translatedAttributes = ['title', 'unit'];

    public $translationModel = UnitTranslation::class;

}
