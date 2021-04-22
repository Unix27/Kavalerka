<?php


namespace Customers\Http\Controllers;


use Admin\helpers\FormGenerator;
use App\Http\Controllers\Controller;
use Customers\DataGrids\CustomerGroupsDataGrid;
use Customers\Repositories\CustomerGroupsRepository;
use Customers\Models\CustomerGroup as Model;

class CustomerGroupsController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->middleware('admin');
        $this->repository = app(CustomerGroupsRepository::class);
    }

    public function index()
    {
        $datagrid = new CustomerGroupsDataGrid();
        $page_title = 'Клиенты';
        return view('admin::customer_groups.index', compact('datagrid', 'page_title'));
    }

    public function create()
    {
        $form = new FormGenerator(config('admin.forms.customer_groups'));

        \View::share('form', $form);
        return view('admin::customer_groups.create');
    }

    public function store()
    {

        $attributes = request()->all();

        $model = $this->repository->create($attributes);

        return redirect()->route('admin.customer_groups.edit', $model->id);
    }

    public function edit($id)
    {
        $model = Model::findOrFail($id);

        $form = new FormGenerator(config('admin.forms.customer_groups'));
        $form->setValues($model->toArray());

        \View::share('form', $form);

        return view('admin::customer_groups.edit', compact('model'));
    }

    public function update($id)
    {
        $attributes = request()->all();

        $model = Model::findOrFail($id);

        $model = $this->repository->update($model, $attributes);

        return redirect()->back();
    }
}
