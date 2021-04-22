<?php


namespace Blog\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Blog\Api\Resources\CategoryResource;
use Blog\Api\Resources\CategoryTableResource;
use Blog\Repositories\BlogCategoryRepository as Repository;
use Blog\Models\BlogCategory as Model;

class CategoriesController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->middleware('admin');
        $this->repository = app(Repository::class);
    }

    public function index()
    {
        return CategoryTableResource::collection(Model::all());
    }

    public function table()
    {
        $dt = new Datatable();
        $query = Model::query();

        return CategoryTableResource::collection($dt->get($query));
    }

    public function show($id)
    {
        return new CategoryResource(Model::findOrFail($id));
    }

    public function store()
    {
        $customer = $this->repository->create(request()->all());

        return response()->json($customer->toArray());
    }

    public function update($id)
    {
        $customer = Model::findOrFail($id);

        $customer = $this->repository->update($customer, request()->all());

        return new CategoryResource($customer);
    }

    public function destroy($id)
    {
        $customer = Model::findOrFail($id);
        try {
            $customer->delete();
        } catch (\Exception $e) {
        }

        return response()->json('ok');
    }
}
