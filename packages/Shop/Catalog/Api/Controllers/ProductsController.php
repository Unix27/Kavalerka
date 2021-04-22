<?php


namespace Shop\Catalog\Api\Controllers;


use Admin\Services\DatatableProduct;
use App\Http\Controllers\Controller;
use Shop\Catalog\Api\Resources\ProductResource;
use Shop\Catalog\Api\Resources\ProductTableResource;
use Shop\Catalog\Models\Product as Model;
use Shop\Catalog\Repositories\ProductsRepository as Repository;
use Illuminate\Http\Request;
class ProductsController extends Controller
{


    public function __construct()
    {
        $this->middleware('admin');
        $this->repository = app(Repository::class);
    }

    public function index(Request $request)
    {

        $input = $request->all();
        $dt = new DatatableProduct();
        $query = Model::query();

        if(isset($input['q'])){
            $query = $query->whereTranslationLike('title',"%".$input['q']."%");

            if(isset($input['without']))
                $query = $query->whereNotIn('id',explode(',',$input['without']));
        }

        if(isset($input['generalSearch'])){

            $q =  request('generalSearch');
            $query = $query->whereHas('variations',function(\Illuminate\Database\Eloquent\Builder $query) use ($q){
                return $query->where('title', 'LIKE','%'.$q.'%')
                    ->orWhere('sku', 'LIKE','%'.$q.'%');
            })
            ->orwhereTranslationLike('title',"%".$input['generalSearch']."%")
            ->orWhere('sku', 'LIKE','%'.$input['generalSearch'].'%');
        }
        return ProductTableResource::collection($dt->get($query));
    }

    public function search(Request $request)
    {


        $input = $request->all();
        $posts = Model::query()->
        whereTranslationLike('title',"%".$input['q']."%")
               ->whereNotIn('id',[16])
            ->get();
        return [
            $posts,
            $input
        ];
    }

    public function store()
    {
        $model = $this->repository->create(request()->all());

        return new ProductResource($model);
    }

    public function update($id)
    {
        $model = Model::findOrFail($id);
        $model = $this->repository->update($model, request()->all());


        return new ProductResource($model);
    }

    public function show($id)
    {
        $model = Model::findOrFail($id);

        return new ProductResource($model);
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

    public function SaveImage(Request $request){
       return [$request->allFiles()];
    }
}
