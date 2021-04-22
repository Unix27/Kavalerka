<?php


namespace Blog\Repositories;


use Blog\Models\BlogCategory as Model;

class BlogCategoryRepository
{
    public function __construct()
    {

    }

    public function create($attributes)
    {

        if(empty($attributes['title']))
            $attributes['title'] = 'Без имени';

        if(empty($attributes['slug']))
            $attributes['slug'] = \Str::slug($attributes['title']);

        $model = new Model();

        $model->translateOrNew(app()->getLocale())->fill($attributes);

        $model->save();

        return $model;
    }

    public function update(Model $model, $attributes)
    {

        if(empty($attributes['slug']))
            $attributes['slug'] = \Str::slug($attributes['title']);

        $model->translateOrNew(app()->getLocale())->fill($attributes);

        $model->save();

        return $model;
    }


    public function findBySlugOrFail($slug)
    {
        $category = Model::where('slug', $slug)->first();

        if(!$category)
            abort(404);

        return $category;
    }
}
