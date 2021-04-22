<?php

namespace Core\Settings\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = ['updated_at', 'id'];

    public function scopeGroup($query, $groupName)
    {
        return $query->whereGroup($groupName);
    }
}
