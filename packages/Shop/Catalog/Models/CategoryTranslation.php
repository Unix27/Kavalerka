<?php

namespace Shop\Catalog\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    protected $table = 'shop_category_translations';

    protected $fillable = ['title', 'description',
        'meta_title', 'meta_description', 'meta_keywords', 'seo_text'];
}
