<?php


namespace Admin\Repositories;

use Admin\Models\AdminRole;
use Core\Settings\Models\Currency as Model;

class AdminRolesRepository
{
    public function create($attributes)
    {
        $model = AdminRole::create($attributes);
        $model->save();

        if(isset($attributes['permissions'])) {
            $model->permissions()->sync($attributes['permissions']);
        }

        return $model;
    }

    public function update(AdminRole $page, $attributes)
    {
        $page->fill($attributes);
        $page->save();

        if(isset($attributes['permissions'])) {
            $page->permissions()->sync($attributes['permissions']);
        }
        return $page;
    }

}
