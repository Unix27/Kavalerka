<?php

namespace Shop\Catalog\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package Shop\Catalog\Models
 * @mixin \Eloquent
 */

class Brand extends Model
{
    use Translatable;

    protected $table = 'shop_brands';

    public $searchable = ['title', 'description'];

    public $translatedAttributes = ['title', 'description'];

    public $translationModel = BrandTranslation::class;

    protected $fillable = ['active','image','sort'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
