<?php


namespace Blog\Http\Controllers;

use Admin\Theme\Init;
use App\Http\Controllers\Controller;
use Blog\DataGrids\BlogCategoriesDataGrid;
use Blog\Models\BlogCategory as Model;
use Blog\Models\BlogCategoryTranslation;
use Illuminate\Http\Request;
use Localization;
use Str;

class CategoriesAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $page_title = 'Категории';
        $datagrid = new BlogCategoriesDataGrid();
        return view('admin::blog.categories.index', compact('datagrid', 'page_title'));
    }

    public function create()
    {
        config()->set('admin.layout.subheader.display', false);
        config()->set('admin.layout.content.width', 'fixed');
        Init::run();

        return view('admin::blog.categories.create');
    }

    public function edit(Model $category)
    {
        config()->set('admin.layout.subheader.display', false);
        config()->set('admin.layout.content.width', 'fixed');
        Init::run();

        if (request()->has('locale')) {
            $editorLocale = request()->input('locale');
        } else {
            $editorLocale = Localization::getDefaultLocale();
        }

        $translation = $category->translations()->where('locale', $editorLocale)->first();
        return view('admin::blog.categories.edit',
            ['model' => $category, 'translation' => $translation, 'editorLocale' => $editorLocale]);
    }

    public function store(Request $request)
    {

        $model = new Model();
        $model->name = $request->input('title');
        $model->slug = $request->input('slug') ?? Str::slug($request->input('title'));

        $model->save();

        $translation = new BlogCategoryTranslation();
        $translation->category_id = $model->id;
        $translation->fill($request->all());
        $translation->save();

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'Категория успешно добавлена');
    }

    public function update(Model $category, Request $request)
    {

        if($request->input('locale') == Localization::getDefaultLocale()) {
            $category->name = $request->input('title');
            $category->save();
        }

        $translation = $category->translations()->where('locale', $request->input('locale'))->first();

        if(!$translation) {
            $translation = new BlogCategoryTranslation();
            $translation->category_id = $category->id;
        }

        $translation->fill($request->all());
        $translation->save();

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'Категория успешно сохранена');
    }
}
