<?php

namespace Shop\Catalog\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AttributeGroup
 * @package Shop\Catalog\Models
 * @mixin \Eloquent
 */

class AttributeGroup extends Model
{
    use Translatable;

    protected $table = 'shop_attribute_groups';

    public $searchable = ['title'];

    public $translatedAttributes = ['title'];

    public $translationModel = AttributeGroupTranslation::class;

    protected $fillable = ['code', 'active', 'sort'];

    public function atts()
    {
        return $this->hasMany(Attribute::class, 'attribute_group_id', 'id');
    }
}
