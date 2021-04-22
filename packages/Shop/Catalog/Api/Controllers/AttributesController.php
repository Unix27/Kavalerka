<?php


namespace Shop\Catalog\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Shop\Catalog\Api\Resources\AttributesValuesResource;
use Shop\Catalog\Api\Resources\AttributeTableResource;
use Shop\Catalog\Models\Attribute;
use Shop\Catalog\Models\AttributeValue;
use Shop\Catalog\Models\Product;
use Shop\Catalog\Repositories\AttributesRepository;
use Symfony\Component\VarDumper\Cloner\Data;
use Illuminate\Http\Request;

class AttributesController extends Controller
{
	protected $repository;
	protected $datatable;
	public function __construct()
	{
		$this->middleware('admin');
		$this->repository = app(AttributesRepository::class);
		$this->datatable = new Datatable();
	}

	public function index()
	{

		$query = Attribute::query();

		return AttributeTableResource::collection($this->datatable->get($query));
	}

	public function show($id)
	{
		$attribute = Attribute::findOrFail($id);

		return response()->json($attribute->toArray());
	}

	public function store()
	{
		$input = request()->all();
//		$input['attribute_group_id'] = $input['groups'];

		$attribute = $this->repository->create($input);

		return response()->json($attribute->toArray());
	}

	public function update($id)
	{
		$attribute = Attribute::findOrFail($id);

		$attribute = $this->repository->update($attribute, request()->all());

		return response()->json($attribute->toArray());
	}

	public function findByProductId($id, Request $request){



//
//        $attributes = AttributeValue::where([
//           ['shop_products_shop_attributes.product_id','=',$id]
//        ])
//        ->rightJoin('shop_attributes','shop_attributes.id','=','shop_attribute_values.attribute_id')
//        ->join('shop_attribute_translations','shop_attribute_translations.attribute_id','=','shop_attributes.id')
//        ->join('shop_products_shop_attributes','shop_products_shop_attributes.attribute_id','=','shop_attribute_translations.attribute_id')
//        ->groupBy('shop_attributes.id')
//        ->select('shop_attributes.id','shop_attribute_translations.title')
////        ->where('shop_products_shop_attributes.locale',app()->getLocale())
//        ->get();


		$attributes = Attribute::join('shop_attribute_values','shop_attribute_values.attribute_id','=','shop_attributes.id')
			->join('shop_products_shop_attributes','shop_products_shop_attributes.attribute_id','=','shop_attribute_values.id')
			->join('shop_attribute_translations','shop_attribute_translations.attribute_id','=','shop_attributes.id')
			->join('shop_products_shop_attr','shop_products_shop_attr.attribute_id','=','shop_attributes.id')
			->where('shop_products_shop_attr.product_id',$id)
			->groupBy('shop_attributes.id')
			->select('title')
			->get();


		$res = [];
		foreach($attributes as $key => $value){
			$res[$key] = $value;
			$res[$key]['slug'] = $value->id;
			$res[$key]['title'] = $value->title;
		}


		$res[] = [
			'slug' => 'title',
			'title' => 'Название'
		];

		$res[] = [
			'slug' => 'article',
			'title' => 'Артикул'
		];

		$res[] = [
			'slug' => 'price',
			'title' => 'Цена'
		];

		$res[] = [
			'slug' => 'quantity',
			'title' => 'На складе'
		];
		return [
			'data'=>$res,
			'attributes' => $attributes,
		];


	}

	public function destroy($id)
	{
		$model = Attribute::findOrFail($id);
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
			$model = Attribute::whereTranslationLike('title',$input['title']);

			if(is_numeric($input['id']))
				$model = $model->where('id','!=',$input['id']);

			return ['data'=>$model->first()?false:true];
		}



		return ['data'=>true];
	}
}
