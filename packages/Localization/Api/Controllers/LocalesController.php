<?php


namespace Localization\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Localization\Api\Resources\LocaleTableResource;
use Localization\Models\Locale;

class LocalesController extends Controller
{
    public function index()
    {
        $datatable = new Datatable();

        $query = Locale::query();
        if(request('generalSearch')){
            $query = $query->where('name','like',"%".request('generalSearch')."%");
        }



        return LocaleTableResource::collection($datatable->get($query));
    }

    public function activeLocales()
    {
        $locales = Locale::where('active', true)->get();

        return LocaleTableResource::collection($locales);
    }


    public function setActive($id,Request $request){

        $locale = Locale::find($id);
        $locale->active = $request->active;
        $locale->save();

        return response()->json('ok');
    }

    public function setDefault($id,Request $request){

        $default_locale = Locale::where('default',1)->update(['default' => 0]);

        $locale = Locale::find($id);
        $locale->default = $request->default;
        $locale->save();

        return response()->json('ok');
    }

}
