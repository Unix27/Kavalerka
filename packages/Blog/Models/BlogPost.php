<?php

namespace Blog\Models;

use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed created_at
 * @property integer status
 * @property integer likes
 * @property string StatusText
 * @property integer TimeReading
 * @property string slug
 * @property string title
 * @property string content
 * @property integer created_by
 * @property integer published_by
 * @property mixed published_at
 * @property string meta_title
 * @property string meta_description
 * @property string meta_keywords
 * @property int category_id
 * @property string name
 * @property string image
 * @property string ThumbnailUlr
 * @property string ImageUlr
 * @mixin Eloquent
 */

class BlogPost extends Model
{
    use Translatable;

    public $translationModel = BlogPostTranslation::class;

    public $translatedAttributes = ['title', 'content', 'excerpt',
        'meta_title', 'meta_description', 'meta_keywords', 'locale' ];

    public $searchable = ['title'];

    public $translationForeignKey = 'post_id';

    protected $fillable = ['name', 'image', 'category_id', 'tags', 'image', 'slug'];

    protected $dates = ['published_at'];

    protected $casts = ['tags' => 'array'];

    public function related()
    {
        return $this->belongsToMany(BlogPost::class,
            'blog_post_related', 'post_id', 'related_id');
    }

    public function category()
    {
        return $this->hasOne(BlogCategory::class, 'id', 'category_id');
    }

    public function getTimeReadingAttribute()
    {
        $speed = 120;  //   words/min
        $text = strip_tags($this->content);
        $countWords = count(explode(' ', $text));

        return round($countWords/$speed);
    }
}
