<?php


namespace Shop\Promocodes\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Shop\Catalog\Models\Brand;
use Shop\Catalog\Models\Category;
use Shop\Orders\Models\Order;
use Shop\Promocodes\Models\Promocode;
use Shop\Promocodes\Api\Resources\PromocodesResource;

use Shop\Promocodes\Repositories\PromocodesRepositories;

class PromocodesController extends Controller
{
	protected $repository;

	public function __construct()
	{
		$this->middleware('admin');
		$this->repository = app(PromocodesRepositories::class);
	}

	public function index()
	{
		$dt = new Datatable();

		$query = Promocode::query();

		return PromocodesResource::collection($dt->get($query));
	}

	public function show($id)
	{
		$return = Promocode::findOrFail($id);

		return new PromocodesResource($return);
	}

	public function store()
	{
		$return = $this->repository->create(request()->all());
		return new PromocodesResource($return);
	}

	public function update($id)
	{
		$promotion = Promocode::findOrFail($id);
		$promotion = $this->repository->update($promotion, request()->all());

		return new PromocodesResource($promotion);
	}

	public function destroy($id)
	{
		$model = Promocode::findOrFail($id);
		try {
			$model->delete();
			return response()->json('ok');
		} catch (\Exception $e) {
			return response()->json($e);
		}
	}

	public function categories(){
		$categories = Category::where('parent_id', '=', null)->get();

		return $this->treeCategories($categories);
	}

	public function treeCategories($categories){
		$tree = [];

		foreach($categories as $cat){

			if(count($cat->children)){
				$children = [];
				$children['label'] = $cat->title;
				$children['id'] = $cat->id;
				$children['children'] = $this->treeCategories($cat->children);

				$tree[] = (object)$children;
			}else{
				$tree[] = (object)[
					'label' => $cat->title,
					'id'   => $cat->id,
				];
			}

		}

		return $tree;
	}

}
