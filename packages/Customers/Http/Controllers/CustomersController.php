<?php


namespace Customers\Http\Controllers;


use Admin\helpers\FormGenerator;
use App\Http\Controllers\Controller;
use Customers\DataGrids\CustomersDataGrid;
use Customers\Repositories\CustomersRepository;
use Customers\Models\Customer as Model;

class CustomersController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->middleware('admin');
        $this->repository = app(CustomersRepository::class);
    }

    public function index()
    {
        $datagrid = new CustomersDataGrid();
        $page_title = 'Клиенты';
        \View::share('page_title', $page_title);
        return view('admin::customers.index', compact('datagrid', 'page_title'));
    }

    public function create()
    {
        $form = new FormGenerator(config('admin.forms.customers_create'));
        $page_title = 'Создать клиента';

        \View::share('form', $form);
        \View::share('page_title', $page_title);

        return view('admin::customers.create');
    }

    public function store()
    {

        $attributes = request()->all();

        $model = $this->repository->create($attributes);

        return redirect()->route('admin.customers.edit', $model->id);
    }

    public function edit($id)
    {
        $form = new FormGenerator(config('admin.forms.customers_edit'));

        $model = Model::findOrFail($id);

        $form->setValues($model->toArray());

        $page_title = 'Изменить клиента';

        \View::share('form', $form);
        \View::share('model', $model);
        \View::share('page_title', $page_title);

        return view('admin::customers.edit');
    }

    public function update($id)
    {
        $attributes = request()->all();

        $model = Model::findOrFail($id);

        $model = $this->repository->update($model, $attributes);

        return redirect()->route('admin.customers.edit', $model->id);
    }

    public function show($id)
    {
        $model = Model::findOrFail($id);
        $page_title = 'Клиент';
        \View::share('model', $model);
        \View::share('page_title', $page_title);

        return view('admin::customers.show');
    }

    public function login($id)
    {
        $model = Model::findOrFail($id);
        \Auth::guard('customer')->login($model, true);

        return redirect('/');
    }
}
