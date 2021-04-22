<?php

namespace Pages\Models;

use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Core\Settings\Models\Slider;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed created_at
 * @property string slug
 * @property string title
 * @property string meta_title
 * @property string meta_description
 * @property string meta_keywords
 * @property string name
 * @mixin Eloquent
 */

class Page extends Model
{
	use Translatable;


	public $translationModel = PageTranslation::class;

	public $translatedAttributes = ['title', 'content',
		'meta_title', 'meta_description', 'meta_keywords'];


	public $searchable = ['title'];
	public $translationForeignKey = 'page_id';


	protected $fillable = ['name', 'slug'];

	public function slider()
	{
		return $this->hasMany(Slider::class,'page_id','id');
	}
}
