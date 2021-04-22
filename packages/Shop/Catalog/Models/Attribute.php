<?php

namespace Shop\Catalog\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Attribute
 * @property mixed id
 * @package Shop\Catalog\Models
 * @mixin \Eloquent
 */

class Attribute extends Model
{
    use Translatable;

    protected $table = 'shop_attributes';

    public $searchable = ['title', 'description'];

    public $translatedAttributes = ['title', 'description'];

    public $translationModel = AttributeTranslation::class;

//    protected $fillable = ['active', 'use_filter', 'attribute_group_id', 'required', 'sort','use_color'];
    protected $fillable = ['active', 'use_filter', 'required', 'sort','use_color'];

    public function group()
    {
        return $this->hasOne(AttributeGroup::class, 'id', 'attribute_group_id');
    }

    public function options()
    {
        return $this->hasMany(AttributeOption::class, 'attribute_id', 'id');
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id', 'id');
    }

		public function selectedValues()
		{
			return $this->belongsToMany(AttributeValue::class,
				'shop_products_shop_attributes','attribute_id','product_id'
			)->withPivot('show');
		}

		public function products(){
			return $this->belongsToMany(Product::class,'shop_products_shop_attr','attribute_id','product_id');
		}

}
