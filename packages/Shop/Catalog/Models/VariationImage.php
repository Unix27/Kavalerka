<?php

namespace Shop\Catalog\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bool|mixed url
 * @property mixed product_id
 * @mixin \Eloquent
 */
class VariationImage extends Model
{
    protected $table = 'shop_variation_images';
    public $fillable = ['url','variation_id','sort'];


    public function variation()
    {
        return $this->hasMany(Variations::class);
    }


}
