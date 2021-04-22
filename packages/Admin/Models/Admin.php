<?php

namespace Admin\Models;

use Eloquent;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @property string password
 * @property mixed roles
 * @property mixed id
 * @property mixed google2fa_secret
 * @property mixed Role
 * @mixin Eloquent
 */
class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'login', 'email', 'password',
    ];


    public function getRoleNameAttribute()
    {
        if (!empty($this->roles->first()))
            return $this->roles->first()->name;
        else return '';
    }

    public function getRoleAttribute()
    {
        if (!empty($this->roles->first()))
            return $this->roles->first();
        else return null;
    }


    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, 'admin_roles_to_admins', 'admin_id', 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(AdminPermission::class, 'admin_permissions_to_admins', 'admin_id', 'permission_id');
    }

    public function getAllPermissions()
    {
        if(isset($this->Role))
            return $this->Role->permissions()->get();
        else return [];
    }
}
