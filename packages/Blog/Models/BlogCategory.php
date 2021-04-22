<?php

namespace Blog\Models;

use Astrotomic\Translatable\Translatable;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed name
 * @property string slug
 * @property mixed posts
 * @mixin Eloquent
 */
class BlogCategory extends Model
{
    use Translatable;

    public $translationModel = BlogCategoryTranslation::class;

    public $translatedAttributes = ['title', 'seo_text', 'slug',
        'meta_title', 'meta_description', 'meta_keywords'];

    public $searchable = ['title'];

    public $translationForeignKey = 'category_id';


    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'category_id');
    }


    public static function boot () {
        parent::boot();

        self::deleting(function (self $category) {
            foreach ($category->posts as $post) {
                /**
                 * @var BlogPost $post
                 */

                $post->status = 0;
                $post->save();
            }
        });
    }
}
