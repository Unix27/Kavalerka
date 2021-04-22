<?php

namespace Localization\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property string code
 * @property mixed name
 * @property mixed script
 * @property mixed native
 * @property mixed regional
 * @property bool active
 * @property bool default
 * @property bool|mixed is_visible_site
 * @mixin Eloquent
 */
class Locale extends Model
{
    public $fillable = ['name','code','regional','script'];

    protected $table = 'locales';


}
