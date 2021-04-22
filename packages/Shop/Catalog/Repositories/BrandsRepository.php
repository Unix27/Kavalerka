<?php


namespace Shop\Catalog\Repositories;

use Shop\Catalog\Models\Brand as Model;
use Storage;

class BrandsRepository
{
    protected $locale;
    protected $imagesPath;

    public function __construct()
    {
        $this->locale = app()->getLocale();
        $this->imagesPath = 'shop/images';
    }

    public function create(array $attributes)
    {
        if(empty($attributes['slug']))
            $attributes['slug'] = \Str::slug($attributes['title']);


        $model = Model::create($attributes);

        $model->translateOrNew($this->locale)->fill($attributes);

        // if(isset($attributes['image'])) {
        //     $image = Storage::put($this->imagesPath, $attributes['image']);
        //     $model->image = $image;
        // }

        $model->save();

        return $model;
    }

    public function update(Model $model, array $attributes)
    {
        $model->fill($attributes);

        $model->save();

        $model->translateOrNew($this->locale)->fill($attributes);

        // if(isset($attributes['image'])) {
        //     $image = Storage::put($this->imagesPath, $attributes['image']);
        //     $model->image = $image;
        // }

        $model->save();

        return $model;
    }

    public function getForSelect()
    {
        $categories = Model::all();
        $result = [];

        foreach ($categories as $category) {

            $translation = $category->hasTranslation($this->locale) ?
                $category->getTranslation($this->locale) :
                $category->translations()->first();

            $result[$category->id] = $translation->title;
        }

        return $result;
    }
}


