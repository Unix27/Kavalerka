<?php


namespace Shop\Catalog\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Shop\Catalog\Api\Resources\AttributeGroupResource;
use Shop\Catalog\Api\Resources\AttributeGroupTableResource;
use Shop\Catalog\Models\AttributeGroup as Model;
use Shop\Catalog\Repositories\AttributeGroupsRepository;

class AttributeGroupsController extends Controller
{
    protected $repository;
    protected $datatable;

    public function __construct()
    {
        $this->middleware('admin');
        $this->repository = app(AttributeGroupsRepository::class);
        $this->datatable = new Datatable();
    }

    public function index()
    {
        $query = Model::query();
        return AttributeGroupTableResource::collection($this->datatable->get($query));
    }

    public function store()
    {
//        return(([request()->all()]));
        $model = $this->repository->create(request()->all());

        return new AttributeGroupResource($model);
    }

    public function update($id)
    {
        $model = $this->repository->update(Model::findOrFail($id), request()->all());

        return new AttributeGroupResource($model);
    }

    public function show($id)
    {
        return new AttributeGroupResource(Model::findOrFail($id));
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
