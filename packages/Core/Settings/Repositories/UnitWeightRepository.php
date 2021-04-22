<?php


namespace Core\Settings\Repositories;
use Core\Settings\Models\UnitWeight as Model;

class UnitWeightRepository
{
    protected $locale;

    public function __construct()
    {
        $this->locale = request()->input('locale') ?? app()->getLocale();
    }

    public function create(array $attributes)
    {

        $model = Model::create($attributes);
        $model->save();

        $model->translateOrNew(app()->getLocale())->fill($attributes);

        $model->save();

        return $model;
    }

    public function update(Model $model, array $attributes)
    {

        $model->fill($attributes);
        $model->save();

        $model->translateOrNew(app()->getLocale())->fill($attributes);
        $model->save();

        return $model;
    }


}
