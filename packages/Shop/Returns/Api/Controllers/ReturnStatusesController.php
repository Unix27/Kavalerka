<?php


namespace Shop\Returns\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Shop\Orders\Models\Order;
use Shop\Returns\Models\ReturnStatuses as Model;
use Shop\Returns\Api\Resources\ReturnsReasonResource;
use Shop\Returns\Repositories\ReturnRepositories;
use Shop\Returns\Repositories\ReturnStatusRepository;

class ReturnStatusesController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = app(ReturnStatusRepository::class);
    }

    public function index()
    {
        $dt = new Datatable();

        $query = Model::query();

        return ReturnsReasonResource::collection($dt->get($query));
    }

    public function show($id)
    {
        $return = Model::findOrFail($id);

        return new ReturnsReasonResource($return);
    }

    public function store()
    {
        $order = $this->repository->create(request()->all());

        return new ReturnsReasonResource($order);
    }

    public function update($id)
    {
        $order = Model::findOrFail($id);
        $order = $this->repository->update($order, request()->all());

        return new ReturnsReasonResource($order);
    }

    public function destroy($id)
    {
        $model = Model::findOrFail($id);
        try {
            $model->delete();
            return response()->json('ok');
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }



}
