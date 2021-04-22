<?php


namespace Core\Settings\Api\Controllers;

use Admin\Services\DatatableProduct;
use App\Http\Controllers\Controller;
use Core\Settings\Api\Resources\UnitWeight;

use Core\Settings\Models\UnitWeight as Model;
use Core\Settings\Repositories\UnitWeightRepository as Repository;
use Illuminate\Http\Request;
class UnitWeightController extends Controller
{
    protected $repository;

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

        if(isset($input['generalSearch'])){
            $query = $query->whereTranslationLike('title',"%".$input['generalSearch']."%");
        }

        return UnitWeight::collection($dt->get($query));
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

        return new UnitWeight($model);
    }

    public function update($id)
    {
        $model = Model::findOrFail($id);
        $model = $this->repository->update($model, request()->all());


        return new UnitWeight($model);
    }

    public function show($id)
    {
        $model = Model::findOrFail($id);
        return new UnitWeight($model);
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

    public function validateName(){
        $input = request()->all();

        if(isset($input['title'])){
            $model = Model::whereTranslationLike('title',$input['title']);

            if(is_numeric($input['id']))
                $model = $model->where('id','!=',$input['id']);

            return ['data'=>$model->first()?false:true];
        }

        if(isset($input['value'])){
            $model = Model::where('value',$input['value']);

            if(is_numeric($input['id']))
                $model = $model->where('id','!=',$input['id']);

            return ['data'=>$model->first()?false:true];
        }

        return ['data'=>true];
    }

    public function setDefault($id,Request $request){

        $default = Model::where('default',1)->update(['default' => 0]);

        $model = Model::find($id);
        $model->default = true;
        $model->save();

        return response()->json('ok');
    }
}
