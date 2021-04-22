<?php


namespace Admin\Api\Controllers;


use Admin\Api\Resources\AdminPermissionsResource;
use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Admin\Api\Resources\AdminRolesResource;
use Admin\Models\AdminPermission as Model;
use Admin\Repositories\AdminRolesRepository as Repository;


class AdminPermissionsController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = app(Repository::class);
        $this->middleware('admin');
    }

    public function index()
    {
        $dt = new Datatable();

        $query = Model::query()->where('parent_id',0);
        return AdminPermissionsResource::collection($dt->get($query));
    }

//    public function show($id)
//    {
//        return new AdminRolesResource(Model::findOrFail($id));
//    }
//
//    public function store()
//    {
//        $model = $this->repository->create(request()->all());
//
//        return new AdminRolesResource($model);
//    }
//
//    public function update($id)
//    {
//        $customer = Model::findOrFail($id);
//
//        $customer = $this->repository->update($customer, request()->all());
//
//        return new AdminRolesResource($customer);
//    }
//
//    public function destroy($id)
//    {
//        $customer = Model::findOrFail($id);
//        try {
//            $customer->delete();
//        } catch (\Exception $e) {
//        }
//
//        return response()->json('ok');
//    }
}
