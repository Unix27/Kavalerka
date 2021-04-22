<?php


namespace Shop\Orders\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Shop\Orders\Api\Resources\OrderPaymentMethodsResource;
use Shop\Orders\Api\Resources\OrderStatusResource;
use Shop\Orders\Models\OrderPaymentMethods;
use Shop\Orders\Models\Status;
use Shop\Orders\Repositories\StatusRepository;

class OrderPaymentMethodsController extends Controller
{
//    protected $repository;
//
//    public function __construct()
//    {
//        $this->repository = app(StatusRepository::class);
//    }

    public function index()
    {
        $dt = new Datatable();
        $query = OrderPaymentMethods::query();
        return OrderPaymentMethodsResource::collection($dt->get($query));
    }


}
