<?php


namespace Shop\Promotions\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Shop\Catalog\Models\Brand;
use Shop\Catalog\Models\Category;
use Shop\Orders\Models\Order;
use Shop\Promotions\Models\Promotion;
use Shop\Promotions\Api\Resources\PromotionsResource;

use Shop\Promotions\Repositories\PromotionRepositories;

class PromotionsController extends Controller
{
	protected $repository;

	public function __construct()
	{
		$this->middleware('admin');
		$this->repository = app(PromotionRepositories::class);
	}

	public function index()
	{
		$dt = new Datatable();

		$query = Promotion::query();

		return PromotionsResource::collection($dt->get($query));
	}

	public function show($id)
	{
		$return = Promotion::findOrFail($id);

		return new PromotionsResource($return);
	}

	public function store()
	{
		$return = $this->repository->create(request()->all());
		return new PromotionsResource($return);
	}

	public function update($id)
	{
		$promotion = Promotion::findOrFail($id);
		$promotion = $this->repository->update($promotion, request()->all());

		return new PromotionsResource($promotion);
	}

	public function destroy($id)
	{
		$model = Promotion::findOrFail($id);
		try {
			$model->delete();
			return response()->json('ok');
		} catch (\Exception $e) {
			return response()->json($e);
		}
	}

	public function products(){
		dd(1);
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
