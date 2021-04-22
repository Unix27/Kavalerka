<?php
namespace Shop\Catalog\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Shop\Catalog\Api\Resources\DiscountResource;
use Shop\Catalog\Api\Resources\ProductTableResource;
use Shop\Catalog\Models\Discounts as Model;
use Illuminate\Http\Request;


class DiscountsController extends Controller{

    public function index($id,Request $request){
        $input = $request->all();

        $dt = new Datatable();
        $query = Model::query()->where('product_id',$id);

        if(isset($input['without'])){
            $query = $query->whereTranslationLike('title',"%".$input['q']."%")
                ->whereNotIn('id',explode(',',$input['without']));
        }

        $query= $query->orderBy('id','desc');

        return DiscountResource::collection($dt->get($query));
    }

    public function delete($id){
        Discounts::find($id)->delete();
    }


}
