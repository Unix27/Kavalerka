<?php


namespace Core\Settings\Repositories;
use Core\Settings\Models\Currency as Model;

class CurrencyRepository
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

        return $model;
    }

    public function update(Model $model, array $attributes)
    {

        $model->fill($attributes);
        $model->save();

        return $model;
    }


}
