<?php


namespace Shop\Reviews\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Shop\Reviews\Api\Resources\ProductReviewResource;
use Shop\Reviews\Api\Resources\ProductReviewTableResource;
use Shop\Reviews\Models\ProductsReview;
use Shop\Reviews\Repositories\ProductReviewsRepository;

class ProductReviewsController extends Controller
{
	protected $repository;

	public function __construct()
	{
		$this->repository = app(ProductReviewsRepository::class);
	}

	public function index()
	{
		$dt = new Datatable();
		$query = ProductsReview::query()->where('parent_id', '=', 0);
		return ProductReviewTableResource::collection($dt->get($query));
	}

	public function show($id)
	{
		$review = ProductsReview::findOrFail($id);

		return new ProductReviewResource($review);
	}

	public function store()
	{
		$review = $this->repository->create(request()->all());

		return new ProductReviewResource($review);
	}

	public function update($id)
	{
		$review = ProductsReview::findOrFail($id);
		$review = $this->repository->update($review, request()->all());

		return new ProductReviewResource($review);
	}

	public function destroy($id)
	{
		$model = ProductsReview::findOrFail($id);
		try {
			$model->delete();
			return response()->json('ok');
		} catch (\Exception $e) {
			return response()->json($e);
		}
	}
}
