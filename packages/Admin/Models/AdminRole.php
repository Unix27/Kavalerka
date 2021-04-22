<?php

namespace Admin\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminRole
 * @package Admin\Models
 * @mixin Eloquent
 */

class AdminRole extends Model
{
    protected $fillable = ['name', 'slug'];

    public function permissions()
    {
        return $this->belongsToMany(AdminPermission::class, 'admin_permissions_to_admin_roles', 'role_id', 'permission_id');
    }




//    public static function boot()
//    {
//        parent::boot();
//
//        self::creating(function ($model) {
//            if(empty($model->slug) || $model->slug == '')
//                $model->slug = str_slug($model->name);
//        });
//
//        self::updating(function ($model) {
//            if(empty($model->slug) || $model->slug == '')
//                $model->slug = str_slug($model->name);
//        });
//    }
}
