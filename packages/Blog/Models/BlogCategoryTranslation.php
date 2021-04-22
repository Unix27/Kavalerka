<?php

namespace Blog\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed category_id
 * @property string locale
 * @property mixed title
 */
class BlogCategoryTranslation extends Model
{
    protected $fillable = ['title', 'seo_text', 'slug',
        'meta_title', 'meta_description', 'meta_keywords',
        'locale', 'category_id', 'heading'];
}
