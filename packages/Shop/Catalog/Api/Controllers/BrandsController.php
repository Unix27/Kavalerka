<?php


namespace Shop\Catalog\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Shop\Catalog\Api\Resources\BrandTableResource;
use Shop\Catalog\Models\Brand as Model;
use Shop\Catalog\Repositories\BrandsRepository as Repository;
class BrandsController extends Controller
{
    protected $repository;

    public function __construct()
    {
				$this->middleware('admin');
        $this->repository = app(Repository::class);
    }

    public function index()
    {

        return BrandTableResource::collection(Model::all());
    }

    public function table()
    {
        $dt = new Datatable();

        $query = Model::query();

        return BrandTableResource::collection($dt->get($query));
    }


    public function store()
    {
        $model = $this->repository->create(request()->all());

        return response()->json($model->toArray());
    }

    public function update($id)
    {
        $model = Model::findOrFail($id);
        $model = $this->repository->update($model, request()->all());
        $result = $model->toArray();

        return response()->json($result);
    }

    public function show($id)
    {
        $model = Model::findOrFail($id);

        $result = $model->toArray();

        return response()->json($result);
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
