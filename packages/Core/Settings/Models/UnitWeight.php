<?php

namespace Core\Settings\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class UnitWeight extends Model
{
    use Translatable;

    public $table = 'shop_unit_weights';
    public $fillable = ['value','default'];
    public $translatedAttributes = ['title', 'unit'];

    public $translationModel = UnitWeightTranslation::class;

}
