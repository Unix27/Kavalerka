<?php

namespace Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string slug
 * @property string name
 * @property mixed id
 */
class AdminPermission extends Model
{
    protected $fillable = ['name', 'slug','parent_id','url'];

    public function parent()
    {
        return $this->belongsTo(AdminPermission::class,'parent_id')->where('parent_id',0)->with('parent');
    }

    public function children()
    {
        return $this->hasMany(AdminPermission::class,'parent_id')->with('children')->select('id','parent_id','name as label','slug');
    }


}
