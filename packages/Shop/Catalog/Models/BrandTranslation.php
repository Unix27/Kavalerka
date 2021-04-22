<?php

namespace Shop\Catalog\Models;

use Illuminate\Database\Eloquent\Model;

class BrandTranslation extends Model
{
    protected $table = 'shop_brand_translations';

    protected $fillable = ['title', 'description'];
}
