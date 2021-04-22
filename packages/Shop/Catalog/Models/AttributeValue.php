<?php

namespace Shop\Catalog\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AttributeValue
 * @package Shop\Catalog\Models
 * @mixin \Eloquent
 */

class AttributeValue extends Model
{
    use Translatable;
    protected $table = 'shop_attribute_values';

    protected $fillable = ['attribute_id', 'product_id', 'locale', 'value','color'];

    public $translatedAttributes = ['title'];

    public $translationModel = AttributeValueTranslation::class;

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,
					'shop_products_shop_attributes','attribute_id','product_id'
        );
    }



}
