<?php


namespace Customers\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Customers\Api\Resources\CustomerGroupTableResource;
use Customers\Models\CustomerGroup as Model;
use Customers\Repositories\CustomerGroupsRepository;

class CustomerGroupsController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = app(CustomerGroupsRepository::class);
    }

    public function index()
    {
        return response()->json(['data' => Model::all()->toArray()]);
    }

    public function table()
    {
        $dt = new Datatable();
        $query = Model::query();
        return CustomerGroupTableResource::collection($dt->get($query));
    }

    public function show($id)
    {
        return response()->json(Model::find($id)->toArray());
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

        return response()->json($customer->toArray());
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
