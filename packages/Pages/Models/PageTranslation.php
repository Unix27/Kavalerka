<?php

namespace Pages\Models;

use Pages\EditorJs\HtmlConverter;
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
 * @property mixed page_id
 * @mixin Eloquent
 */
class PageTranslation extends Model
{
    protected $fillable = ['page_id', 'locale', 'title', 'content', 'meta_title', 'meta_description', 'meta_keywords'];

    protected $casts = ['content' => 'object'];

    public function getContentHtmlAttribute()
    {
        return HtmlConverter::getHtml($this->content);
    }
}
