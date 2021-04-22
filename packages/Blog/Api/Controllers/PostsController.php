<?php


namespace Blog\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Blog\Api\Resources\PostResource;
use Blog\Api\Resources\PostTableResource;
use Blog\Models\BlogPost as Model;
use Blog\Repositories\BlogPostRepository as Repository;

class PostsController extends Controller
{
	protected $repository;

	public function __construct()
	{
		$this->repository = app(Repository::class);
		$this->middleware('admin');
	}

	public function index()
	{
		$dt = new Datatable();

		$query = Model::query();

		return PostTableResource::collection($dt->get($query));
	}

	public function show($id)
	{
		return new PostResource(Model::findOrFail($id));
	}

	public function store()
	{
		$customer = $this->repository->create(request()->all());

		return response()->json($customer->toArray());
	}

	public function update($id)
	{
		$customer = Model::findOrFail($id);

		$customer = $this->repository->update($customer, request()->all());

		return new PostResource($customer);
	}

	public function destroy($id)
	{
		$customer = Model::findOrFail($id);
		try {
			$customer->delete();
		} catch (\Exception $e) {
		}

		return response()->json('ok');
	}
}
