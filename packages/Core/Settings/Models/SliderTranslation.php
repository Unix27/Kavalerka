<?php

namespace Core\Settings\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductTranslation
 * @package Shop\Catalog\Models
 * @mixin \Eloquent
 * @property string title
 * @property string description
 */

class SliderTranslation extends Model
{
	protected $table = 'slider_translations';

	protected $fillable = ['title', 'desc',
		'button_name','image','name','link'];
}
