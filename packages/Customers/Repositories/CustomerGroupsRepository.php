<?php


namespace Customers\Repositories;
use Customers\Models\CustomerGroup as Model;

class CustomerGroupsRepository
{

    public function __construct()
    {

    }

    public function create(array $attributes)
    {
        $model = Model::create($attributes);
        $model->save();

        return $model;
    }

    public function update(Model $model, array $attributes)
    {
        $model->fill($attributes);
        $model->save();

        return $model;
    }

    public function getForSelect()
    {
        $categories = Model::all();

        $result = [];

        foreach ($categories as $category) {
            $result[$category->id] = $category->name;
        }

        return $result;
    }
}
