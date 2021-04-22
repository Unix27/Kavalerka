<?php

namespace Core\Settings\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{

    public $table = 'settings_currency';
    public $fillable = ['name','code','left_symbol','right_symbol','number_symbol_comma','value','active','default'];


    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d.m.Y H:i:s');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d.m.Y H:i:s');
    }
}
