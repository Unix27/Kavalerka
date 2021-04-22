<?php

namespace Shop\Orders\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

class CityTranslation extends Model
{
    protected $table = 'cities_translations';

    protected $fillable = [
        'locale', 'title'
    ];

    public $timestamps = false;
}
