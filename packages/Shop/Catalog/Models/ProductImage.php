<?php

namespace Shop\Catalog\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bool|mixed url
 * @property mixed product_id
 * @mixin \Eloquent
 */
class ProductImage extends Model
{
    protected $table = 'shop_product_images';
    public $fillable = ['url','product_id','sort'];


    public function product()
    {
        return $this->hasMany(Product::class);
    }


}
