<?php
namespace Shop\Catalog\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Shop\Catalog\Api\Resources\AttributeTableResource;
use Shop\Catalog\Models\Attribute;
use Shop\Catalog\Models\AttributeValue;
use Shop\Catalog\Models\Product;
use Shop\Catalog\Models\ProductImage;

use Shop\Catalog\Models\VariationImage;
use Shop\Catalog\Models\Variations;
use Shop\Catalog\Repositories\AttributesRepository;
use Symfony\Component\VarDumper\Cloner\Data;

class VariationsController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->middleware('admin');
        $this->repository = app(AttributesRepository::class);
    }

    public function index($id)
    {
        $dt = new Datatable();

        $product = Product::find($id);

        $query = $product->variations()->whereTranslationLike('locale',app()->getLocale())
            ->get();
        $table = [];


//        $attributes = AttributeValue::where([
//            ['product_id','=',$id]
//        ])->get()->groupBy('attribute_id');

        $attr = $product->useVar()->get()->pluck('id');
        $attributes =  $product->attributesGet()->whereIn('shop_attribute_values.attribute_id',$attr)->get()->groupBy('attribute_id');

        foreach($query as $key => $value){
            $var = \DB::table('shop_variation_values')->where([
                ['variation_id','=',$value->id]
            ])->join('shop_attribute_values','shop_variation_values.value_id','=','shop_attribute_values.id')
//                ->where('locale',app()->getLocale())
                ->get()
                ->keyBy('attribute_id');

            $table[$key] = $value;
            $table[$key]['attr'] = $var;
        }



        return [
            'query' => $query,
            'data' => $table,
            'attributes' => $attributes
        ];
    }

    public function save($id){
        $input = request()->all();
        $variation = Variations::find($id);
        $variation->fill($input);


        $variation->save();

        if(isset($input['fileList'])) {
            foreach ($input['fileList'] as $key => $file) {
                if(isset($file['fullSize'])) {
                    $image_64 = $file['fullSize']; //your base64 encoded data
                    $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
                    $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
                    $image = str_replace($replace, '', $image_64);
                    $image = str_replace(' ', '+', $image);
                    $imageName = \Str::random(10) . '.' . $extension;
                    \Storage::disk('shop')->put($imageName, base64_decode($image));
                    $data = \Storage::disk('shop')->url($imageName);

                    $image = new VariationImage();
                    $image->variation_id = $id;
                    $image->sort = $key;
                    $image->url = $data;

                    $image->save();
                }
            }
        }




        return response()->json('ok');
    }

    public function edit($id){
        $variation = Variations::find($id);
        return [
            'data' => $variation
        ];
    }


    public function delete($id){
        Variations::find($id)->delete();
    }

    public function images(){

    }



}
