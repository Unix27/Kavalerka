<?php


namespace Shop\Promotions\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Shop\Promotions\Api\Resources\CategoryTableResource;
use Shop\Promotions\Models\PromotionsCategory as Model;
use Shop\Promotions\Repositories\CategoryRepository as Repository;

class CategoryController extends Controller
{
	protected $repository;

	public function __construct()
	{
		$this->middleware('admin');
		$this->repository = app(Repository::class);
	}

	public function index()
	{
		return CategoryTableResource::collection(Model::all());
	}

	public function table()
	{
		$dt = new Datatable();


		$query = Model::query();

		return CategoryTableResource::collection($dt->get($query));
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


		return $model;
		$result = $model->toArray();

		return response()->json($result);
	}

	public function show($id)
	{
		$model = Model::findOrFail($id);

		$result = $model->toArray();

//		$result['active'] = $result['status_id'] == 2?0:1;

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

	public function validateName(){
		$input = request()->all();

		if(isset($input['title'])){
			$model = Model::whereTranslationLike('title',$input['title']);

			if(is_numeric($input['id']))
				$model = $model->where('id','!=',$input['id']);

			return ['data'=>$model->first()?false:true];
		}



		return ['data'=>true];
	}
}
