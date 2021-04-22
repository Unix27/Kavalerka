<?php


namespace Localization\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Localization\Api\Resources\TranslationTableResource;
use Localization\Models\Translation;
use Localization\Helpers\Manager;

class TranslationsController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = app(Manager::class);
        $this->middleware('admin');
    }

    public function index()
    {
        $filter = request('filter') ?? null;

        $query = Translation::query();
        $datatable = new Datatable();

        if(!empty($filter)) {
            $query = $query->where('group', $filter['group']);
        }

        $query = $query->where('locale', app()->getLocale());


        if(request('generalSearch')){
            $query = $query->where(function($q) {
                    $q->where('key','like','%'.request('generalSearch').'%')
                        ->orWhere('value','like','%'.request('generalSearch').'%');
                    });
        }

//





        return TranslationTableResource::collection($query->paginate());
    }

    public function groups()
    {
        $groups = Translation::groupBy('group')->pluck('group', 'group');
        return response()->json(['data' => $groups->toArray()]);
    }

    public function import()
    {
         $this->helper->importTranslations();

        return response()->json(Translation::all()->toArray());
    }


    public function update($id,Request $request){

        if(substr_count($request->value,'</p>') == 1)
            $request->value =strip_tags($request->value);

        Translation::find($id)->update(['value' => $request->value]);
        return response()->json('ok');
    }
}
