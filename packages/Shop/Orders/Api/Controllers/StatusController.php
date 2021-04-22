<?php


namespace Shop\Orders\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Shop\Orders\Api\Resources\OrderStatusResource;
use Shop\Orders\Models\Status;
use Shop\Orders\Repositories\StatusRepository;

class StatusController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = app(StatusRepository::class);
    }

    public function index()
    {
        $dt = new Datatable();
        $query = Status::query();
        return OrderStatusResource::collection($dt->get($query));
    }

    public function update(Request $request){

        $input = $request->all();

        foreach($input['statuses'] as $value){
            $status = Status::find($value['id']);
            $status->fill($value);
            $status->save();
        }

        return true;

    }

}
