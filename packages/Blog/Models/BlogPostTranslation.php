<?php

namespace Blog\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed post_id
 * @property string title
 * @property string content
 * @property string meta_title
 * @property string meta_description
 * @property string meta_keywords
 * @property string locale
 * @property string ContentHtml
 * @mixin Eloquent
 */
class BlogPostTranslation extends Model
{
    protected $casts = [
        'content' => 'object'
    ];

    protected $fillable = [
        'post_id', 'locale', 'title', 'content', 'excerpt',
        'meta_title', 'meta_description', 'meta_keywords'
    ];

}
