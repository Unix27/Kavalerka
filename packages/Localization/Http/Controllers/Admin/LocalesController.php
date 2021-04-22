<?php


namespace Localization\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Localization\DataGrids\LocalesDataGrid;
use Localization\Models\Locale as Model;


class LocalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $page_title = 'Языки';
        $datagrid = new LocalesDataGrid();

        return view('admin::locales.index', compact('page_title', 'datagrid'));
    }

    public function create()
    {
        return view('admin::locales.create');
    }

    public function edit(Model $locale)
    {
        return view('admin::locales.edit', ['model' => $locale]);
    }

    public function store(Request $request)
    {
        $model = new Model();
        $model->fill($request->all());
        $model->save();

        return redirect()->route('admin.localization.locales.index')
            ->with('success', 'Язык успешно добавлен');
    }

    public function update(Model $locale, Request $request)
    {
        //dd($request->all());
        $locale->fill($request->all());
        $locale->save();


        return redirect()->route('admin.localization.locales.index')
            ->with('success', 'Язык успешно сохранен');
    }
}
