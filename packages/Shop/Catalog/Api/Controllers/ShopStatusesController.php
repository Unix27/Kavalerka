<?php
namespace Shop\Catalog\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Shop\Catalog\Api\Resources\ShopStatusesResource;
use Shop\Catalog\Models\ShopStatus as Model;
use Shop\Catalog\Repositories\AttributesRepository;

class ShopStatusesController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = app(AttributesRepository::class);
    }

    public function index()
    {

        return ShopStatusesResource::collection(Model::all());
    }




}
