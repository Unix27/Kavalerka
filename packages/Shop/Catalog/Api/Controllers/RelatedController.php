<?php
namespace Shop\Catalog\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Shop\Catalog\Api\Resources\AttributeTableResource;
use Shop\Catalog\Models\Attribute;
use Shop\Catalog\Models\Product;
use Shop\Catalog\Models\Relations;
use Shop\Catalog\Models\ProductImage;
use Shop\Catalog\Api\Resources\ProductRelatedResource;
use Shop\Catalog\Repositories\AttributesRepository;
use Symfony\Component\VarDumper\Cloner\Data;
use Illuminate\Http\Request;
class RelatedController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = app(AttributesRepository::class);
    }

    public function index($type,$id)
    {
		$query = Product::find($id)->relations()->where('type','=',$type);
		
        $dt = new Datatable();

        return ProductRelatedResource::collection($dt->get($query));
    }

    public function delete($type,$id,Request $request){
        $input = $request->all();

    	Relations::where([
            ['current_product_id','=',$id],
            ['type','=',$type],
            ['product_id','=',$input['product_id']],
        ])->delete();
    }

  
}
