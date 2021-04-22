<?php


namespace Blog\Repositories;


use Admin\Models\Admin;
use Blog\Models\BlogCategory;
use Blog\Models\BlogPost as Model;
use Blog\Models\BlogPostTranslation;
use Carbon\Carbon;
use Storage;
use Str;

class BlogPostRepository
{
    protected $locale;

    public function __construct()
    {
        $this->locale = request()->input('locale') ?? app()->getLocale();
    }

    public function getAll()
    {
        $posts = Model::where('status', 1)->get();
        return $posts;
    }

    public function findBySlugOrFail($slug)
    {
        return Model::where('slug', $slug)->firstOrFail();
    }

    public function searchPosts($keyword)
    {
        $postIds = BlogPostTranslation::where('locale', app()->getLocale())
            ->where(function ($query) use ($keyword) {
                return $query->where('title', 'LIKE', "%$keyword%")
                    ->orWhere('content', 'LIKE', "%$keyword%");
            })->get()->pluck('post_id');

        $posts = Model::where('status', 1)
            ->whereIn('id', $postIds)
            ->get();

        return $posts;
    }

    public function searchByTag($tag)
    {
        return Model::where('status', 1)
            ->where('tags', 'LIKE', "%$tag%")
            ->paginate(9);
    }

    public function getAllByCategory(BlogCategory $category)
    {
        return Model::where('status', 1)
            ->where('category_id', $category->id)
            ->get();
    }

    public function create($attributes)
    {

        if(empty($attributes['title']))
            $attributes['title'] = 'Без имени';

        if(empty($attributes['slug']))
            $attributes['slug'] = \Str::slug($attributes['title']);

        $model = Model::create($attributes);

        $model->created_by = Admin::first()->id;

        $model->translateOrNew(app()->getLocale())->fill($attributes);

        $model->save();

        return $model;
    }

    public function update(Model $model, $attributes)
    {

        if(empty($attributes['slug']))
            $attributes['slug'] = \Str::slug($attributes['title']);

        $model->fill($attributes);

        $model->translateOrNew(app()->getLocale())->fill($attributes);

        $model->save();

//        $model->related()->sync($attributes['related']);

        return $model;
    }

    public function publish($id)
    {
        $post = Model::find($id);
        $post->status = 1;
        $post->published_at = Carbon::now()->toDateTimeString();
        $post->published_by = auth('admin')->user()->id;
        $post->save();

        return $post;
    }

    public function unpublish($id)
    {
        $post = Model::find($id);
        $post->status = 0;
        $post->save();

        return $post;
    }

    protected function prepareAttributes($attributes)
    {
        if (empty($attributes['slug']))
            $attributes['slug'] = Str::slug($attributes['name']);

        $attributes['content'] = json_decode($attributes['content']);

        $attributes['image'] = $this->getImageInput(@$attributes['image']);

        return $attributes;
    }

    protected function getImageInput($input)
    {
        $path = config('blog.image_folder');

        if(empty($input)) return false;

        $image = Storage::put($path, $input);

        return str_replace($path . '/', '', $image) ?? false;
    }
}
