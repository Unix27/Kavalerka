<?php


namespace Shop\Catalog\Repositories;

use Shop\Catalog\Models\AttributeValue as Model;
use Storage;

class AttributeValueRepository
{
		protected $locale;

    public function __construct()
    {
        $this->locale = app()->getLocale();
    }

    public function create(array $attributes)
    {
        $model = Model::create($attributes);


        $attributes['title'] = $attributes['value'];
        $model->translateOrNew(app()->getLocale())->fill($attributes);

        $model->save();

        return $model;
    }

    public function update(Model $model, array $attributes)
    {

        $model->fill($attributes);

        $model->translateOrNew(app()->getLocale())->fill($attributes);

        $model->save();

        return $model;
    }
}
