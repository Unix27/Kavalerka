<?php


namespace Shop\Orders\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Shop\Orders\Api\Resources\OrderResource;
use Shop\Orders\Api\Resources\OrderTableResource;
use Shop\Orders\Models\Order;
use Shop\Orders\Repositories\OrdersRepository;

class OrdersController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = app(OrdersRepository::class);
    }

    public function index()
    {
        $dt = new Datatable();
        $query = Order::query();
        return OrderTableResource::collection($dt->get($query));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);

        return new OrderResource($order);
    }

    public function store()
    {
        $order = $this->repository->create(request()->all());

        return new OrderResource($order);
    }

    public function update($id)
    {
        $order = Order::findOrFail($id);
        $order = $this->repository->update($order, request()->all());

        return new OrderResource($order);
    }

    public function destroy($id)
    {
        $model = Order::findOrFail($id);
        try {
            $model->delete();
            return response()->json('ok');
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function updateStatus(Request $request){
        $input = $request->all();
        $order = Order::findOrFail($input['id']);
        $order->status_id = $input['status'];
        $order->save();

        return response()->json('ok');
    }

    public function updatePayment(Request $request){
        $input = $request->all();
        $order = Order::findOrFail($input['id']);
        $order->payment_method_id = $input['payment'];
        $order->save();

        return response()->json('ok');
    }



}
