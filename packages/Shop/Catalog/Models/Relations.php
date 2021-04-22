<?php

namespace Shop\Catalog\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bool|mixed url
 * @property mixed product_id
 * @mixin \Eloquent
 */
class Relations extends Model
{
    protected $table = 'shop_relations';
    public $fillable = ['type','product_id','current_product_id'];


    public function product()
    {
     	return $this->belongsTo(Product::class);
    }


}
