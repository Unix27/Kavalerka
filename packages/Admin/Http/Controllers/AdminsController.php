<?php


namespace Admin\Http\Controllers;

use Admin\DataGrids\AdminsDataGrid;
use Admin\Models\Admin;
use App\Http\Controllers\Controller;

class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $page_title = 'Администраторы';
        $datagrid = new AdminsDataGrid();
        return view('admin::admins.index', compact('datagrid', 'page_title'));
    }

    public function create()
    {
        return view('admin::admins.create');
    }

    public function store()
    {
        //dd(request()->all());

        $admin = new Admin();

        $attributes = request()->except('role');

        $attributes['password'] = bcrypt(request()->get('password'));

        $admin->fill($attributes);
        $admin->save();

        $admin->roles()->attach(request()->get('role'));

        return redirect()->route('admin.admins.index')
            ->with('success', 'Администратор успешно сохранен!');
    }

    public function edit(Admin $admin)
    {
        return view('admin::admins.edit', compact('admin'));
    }

    public function update(Admin $admin)
    {


        $attributes = request()->except('role');

        $attributes['password'] = bcrypt(request()->get('password'));

        $admin->fill($attributes);
        $admin->save();

        $admin->roles()->sync(request()->get('role'));

        $admin->save();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Администратор успешно сохранен!');
    }

    public function show()
    {
    }
}
