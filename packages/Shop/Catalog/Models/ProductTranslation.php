<?php

namespace Shop\Catalog\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductTranslation
 * @package Shop\Catalog\Models
 * @mixin \Eloquent
 * @property string title
 * @property string description
 */

class ProductTranslation extends Model
{
    protected $table = 'shop_product_translations';

    protected $fillable = ['title', 'description', 'characteristics',
        'meta_title', 'meta_description', 'meta_keywords'];
}
