<?php


namespace Pages\Api\Controllers;

use Admin\Services\Datatable;

use App\Http\Controllers\Controller;
use Core\Settings\Models\Slider;
use Illuminate\Http\Request;
use Localization;
use Pages\Models\Page as Model;
use Pages\Repositories\PagesRepository;
use Pages\Api\Resources\PageResource;


class PagesController extends Controller
{

	protected $repository;

	public function __construct()
	{
		$this->middleware('admin');
		$this->repository = app(PagesRepository::class);
	}

	public function index()
	{
		$dt = new Datatable();

		$query = Model::query();

		return PageResource::collection($dt->get($query));
	}


	public function show($id)
	{
		return new PageResource(Model::findOrFail($id));
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

		return new PageResource($customer);
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

	public function slider($page_id){
		$input = request()->all();
		$input['page_id'] = $page_id;
		$input['post_type'] = 'page';

		if(isset($input['id'])){
			$slider = Slider::find($input['id']);
			$slider->fill($input);
			$slider->save();

			$slider->translateOrNew(app()->getLocale())->fill($input);
			$slider->save();

		}else {
			$slider = Slider::create($input);
			$slider->translateOrNew(app()->getLocale())->fill($input);
			$slider->save();
		}
		return $slider;
	}

	public function sliderRemove(){
		$input = request()->all();
		$slider = Slider::find($input['id'])->delete();

		return ['ok'];
	}
}
