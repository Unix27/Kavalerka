<?php


namespace Shop\Orders\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Shop\Orders\Api\Resources\OrderDeliveryResource;
use Shop\Orders\Models\OrderDelivery;

class OrderDeliveriesController extends Controller
{

    public function index()
    {
        $dt = new Datatable();
        $query = OrderDelivery::query();
        return OrderDeliveryResource::collection($dt->get($query));
    }

}
