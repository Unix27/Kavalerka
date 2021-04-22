<?php


namespace Shop\Reviews\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Shop\Reviews\Api\Resources\ReviewResource;
use Shop\Reviews\Api\Resources\ReviewTableResource;
use Shop\Reviews\Models\ProductsReview;
use Shop\Reviews\Models\ShopReview;
use Shop\Reviews\Repositories\ReviewsRepository;
use Spatie\SchemaOrg\Review;

class ReviewsController extends Controller
{
	protected $repository;

	public function __construct()
	{
		$this->repository = app(ReviewsRepository::class);
	}

	public function index()
	{
		$dt = new Datatable();
		$query = ShopReview::query()->where('parent_id', '=', 0);
		return ReviewTableResource::collection($dt->get($query));
	}

	public function show($id)
	{
		$review = ShopReview::findOrFail($id);

		return new ReviewResource($review);
	}

	public function store()
	{
		$review = $this->repository->create(request()->all());

		return new ReviewResource($review);
	}

	public function update($id)
	{
		$review = ShopReview::findOrFail($id);
		$review = $this->repository->update($review, request()->all());

		return new ReviewResource($review);
	}

	public function destroy($id)
	{
		$model = ShopReview::findOrFail($id);
		try {
			$model->delete();
			return response()->json('ok');
		} catch (\Exception $e) {
			return response()->json($e);
		}
	}
}
