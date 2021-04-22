<?php


namespace Shop\Catalog\Repositories;

use Shop\Catalog\Models\AttributeGroup as Model;
use Str;

class AttributeGroupsRepository
{



    public function __construct()
    {

    }

    public function create(array $attributes)
    {
        if(empty($attributes['code']))
            $attributes['code'] = Str::slug($attributes['title']);

        $model = Model::create($attributes);

        // $model->categories()->sync($attributes['categories']);

        $model->translateOrNew(app()->getLocale())->fill($attributes);

        $model->save();

        return $model;
    }

    public function update(Model $model, array $attributes)
    {
        if(empty($attributes['code']))
            $attributes['code'] = Str::slug($attributes['title']);

        $model->fill($attributes);

        $model->save();

        // $model->categories()->sync($attributes['categories']);

        $model->translateOrNew(app()->getLocale())->fill($attributes);

        $model->save();

        return $model;
    }


}
