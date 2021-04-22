<?php


namespace Shop\Catalog\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\AssignOp\Mod;
use Shop\Catalog\Api\Resources\AttributesValuesResource;
use Shop\Catalog\Models\Attribute;
use Shop\Catalog\Models\AttributeValue as Model;
use Shop\Catalog\Repositories\AttributeValueRepository as Repository;
use Illuminate\Http\Request;
class AttributesValueController extends Controller
{
	protected $repository;

	public function __construct()
	{
		$this->middleware('admin');
		$this->repository = app(Repository::class);
	}

	public function index()
	{

		$input = request()->all();
		$query = Model::query();

		if(isset($input['id'])){
			$query = $query->where('attribute_id',$input['id']);
		}


		return AttributesValuesResource::collection($query->get());
	}

	public function table()
	{
		$dt = new Datatable();

		$query = Model::query();

		return AttributesValuesResource::collection($dt->get($query));
	}


	public function store(Request $request)
	{
		$input = request()->all();

		$validate = Model::where([
			'value' => $input['value'],
			'attribute_id' => $input['attribute_id']
		])->first();

		if($validate || $input['value'] == ''){

			$message = '';

			if($input['value']){
				$message = 'Такое значение уже существует';

			}else{
				$message = 'Поле не может быть пустым';
			}

			return [
				'message' => $message,
				'status' =>  'error'
			];
		}


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


	public function updateAll(){


		$input = request()->all();



		$ids = [];

		foreach($input['sAttributes'] as $val){
			if(isset($val['id'])){
				$ids[] = $val['id'];
				$model = Model::findOrFail($val['id']);
				$model = $this->repository->update($model, $val);
			}else{
				$val['attribute_id'] = $input['id'];
				$val['value'] = $val['title'];
				$model = $this->repository->create($val);

				$ids[] = $model->id;
			}
		}

		Model::whereNotIn('id',$ids)->delete();

		return 'ok';

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

	public function filterAttr(){
		$dt = new Datatable();

		$query = Attribute::query();

		$attr = $query->get();

		$selectedAttrVal = [];

		foreach($attr as $k => $val){
			if($val->values->count()) {
				foreach ($val->values as $v) {
					$selectedAttrVal[$val->id][] = [
						'label' => $v->title,
						'id' => $v->id
					];

				}
			}else{
				$selectedAttrVal[$val->id] = [];
			}

		}

		return $selectedAttrVal;

	}

}
