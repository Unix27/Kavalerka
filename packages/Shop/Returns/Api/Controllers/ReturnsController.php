<?php


namespace Shop\Returns\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Shop\Orders\Models\Order;
use Shop\Returns\Models\Returns;
use Shop\Returns\Api\Resources\ReturnsResource;
use Shop\Returns\Api\Resources\TestResource;

use Shop\Returns\Repositories\ReturnRepositories;
class ReturnsController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = app(ReturnRepositories::class);
    }

    public function index()
    {
        $dt = new Datatable();

        $query = Returns::query();

        return ReturnsResource::collection($dt->get($query));
    }

    public function show($id)
    {
        $return = Returns::findOrFail($id);

        return new ReturnsResource($return);
    }

    public function store()
    {
        $return = $this->repository->create(request()->all());
        return new ReturnsResource($return);
    }

    public function update($id)
    {
        $return = Returns::findOrFail($id);
        $return = $this->repository->update($return, request()->all());

        return new ReturnsResource($return);
    }

    public function destroy($id)
    {
        $model = Returns::findOrFail($id);
        try {
            $model->delete();
            return response()->json('ok');
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function updateStatus(Request $request){
        $input = $request->all();
        $return = Returns::findOrFail($input['id']);
        $return->status_id = $input['status'];
        $return->save();

        return response()->json('ok');
    }

    public function updateReason(Request $request){
        $input = $request->all();
        $return = Returns::findOrFail($input['id']);
        $return->reason_id = $input['reason'];
        $return->save();

        return response()->json('ok');
    }



}
